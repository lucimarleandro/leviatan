<?php

/**
 * Este behavior funciona como um espião, armazenando um histórico de alterações
 * nos registros do banco de dados. Suas configurações permitem que se ignorem
 * modificações realizadas por modelos específicos ou em tabelas específicas.
 * 
 * O recurso de ignorar determinados objetos é bastante útil para evitar que se
 * mantenha uma cópia de registros de sessão do cake, por exemplo.
 */
class AuditorBehavior extends ModelBehavior {

    /**
     * @var array lista de tabelas e modelos a ignorar
     */
    private $_ignoreTables = array(
        'Model' => array('Auditor'),
        'Table' => array('cake_sessions', 'acos', 'aros', 'aros_acos')
    );
    private $_settings = array(
        'datasource' => 'audit',
        'table' => 'auditoria'
    );

    /**
     * Esse método é disparado pelo CakePHP quando o behavior é aplicado a algum
     * model.
     * 
     * @param \Model $model objeto modelo no qual o behavior foi aplicado.
     * @param array $config configurações personalizadas.
     */
    public function setup(\Model $model, $config = array()) {
        if (!is_array($config))
            $config = array();

        // Atualiza a lista de tabelas e modelos ignorados.
        if (isset($config['ignore'])) {
            foreach ($config['ignore'] as $type => $arrList) {
                if (in_array($type, array_keys($this->_ignoreTables))) {
                    foreach ($arrList as $name) {
                        if (in_array($name, $this->_ignoreTables[$type]))
                            continue;
                        else
                            $this->_ignoreTables[$type][] = $name;
                    }
                }
            }
            unset($config['ignore']);
        }

        // As demais entradas do array são atualizadas na variável _settings.
        array_replace_recursive($this->_settings, $config);
    }

    /**
     * O método beforeSave não é utilizado porque é gerado um histórico de
     * dados no sistema, assim não é necessário armazenar os dados antigos
     * junto com os dados novos em caso de atualização.
     * 
     * @param \Model $model
     * @param boolean $created
     */
    public function afterSave(\Model $model, $created) {
        if ($this->_isIgnored($model))
            return;

        $this->_initializeModel();
        $this->Auditor->create();
        $this->Auditor->set(array(
            'operacao' => ($created ? 'CREATE' : 'MODIFY'),
            'datahora' => time(),
            'tabela' => $model->table,
            'dados' => json_encode($model->data[$model->name], JSON_FORCE_OBJECT),
            'chave' => $model->id
        ));

        // Obtém a identificação do usuário, caso esteja disponível.
        $this->Auditor->set('usuario', $this->_identificaUsuario($model));

        // Armazena a entrada no histórico.
        $this->Auditor->save();
    }

    public function afterDelete(\Model $model) {
        if ($this->_isIgnored($model))
            return;
        
        $this->_initializeModel();
        $this->Auditor->create();
        $this->Auditor->set(array(
            'operacao' => 'REMOVE',
            'datahora' => time(),
            'tabela' => $model->table,
            'chave' => $model->id,
            'dados' => json_encode($model->data[$model->name], JSON_FORCE_OBJECT)
        ));

        // Obtém a identificação do usuário, caso esteja disponível.
        $this->Auditor->set('usuario', $this->_identificaUsuario($model));

        // Armazena a entrada no histórico.
        $this->Auditor->save();
    }

    /**
     * Verifica se o modelo ou a tabela se encontra na lista dos ignorados.
     * @param \Model $model
     */
    private function _isIgnored(\Model $model) {
        $modelIgnored = in_array($model->name, $this->_ignoreTables['Model']);
        $tableIgnored = ($model->useTable !== FALSE && in_array($model->table, $this->_ignoreTables['Table']));
        return ($modelIgnored || $tableIgnored);
    }

    /**
     * Esse método tenta localizar o id do usuário através do método
     * getUserId() no modelo que está disparando o evento.
     * 
     * @param Model $model 
     * @return string|null retorna a id do usuário como string ou NULL se não
     * conseguiu identificar
     */
    private function _identificaUsuario(\Model $model) {
        if (AuthComponent::user('id') !== NULL)
            return AuthComponent::user('id');
        if ($model->hasMethod('getUserId'))
            return strval($model->getUserId());
        else
            return null;
    }

    /**
     * O modelo utilizado pelo Auditor precisa ser inicializado em tempo de
     * execução e não é inicializado automaticamente pelo Cake.
     * 
     * Removi essas instruções do __construct pra permitir a modificação do
     * datasource e do nome da tabela utilizada pelo Auditor.
     */
    private function _initializeModel() {
        $this->Auditor = ClassRegistry::init('Auditor');
        $this->Auditor->useDbConfig = $this->_settings['datasource'];
        $this->Auditor->useTable = $this->_settings['table'];
        $this->Auditor->primaryKey = 'uuid';
    }

}
