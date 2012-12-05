<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'items', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
    Router::connect('/gerencia.html',
		array(
			'controller'=>'manager',
			'action'=>'index',
		)
	);
    //Itens
	//-------------
     //Home
    Router::connect('/home.html',
		array(
			'controller'=>'items',
			'action'=>'home',
		)
	);
     //index
    Router::connect('/itens.html',
		array(
			'controller'=>'items',
			'action'=>'index',
		)
	);
    //Adicionar itens
    Router::connect('/adicionar-item.html',
		array(
			'controller'=>'items',
			'action'=>'add',
		)
	);
    //Visualizar item
    Router::connect('/item-:id.html',
		array(
			'controller'=>'items',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Editar item
    Router::connect('/editar-item-:id.html',
		array(
			'controller'=>'items',
			'action'=>'edit',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //-------------------------
    //Pedidos
    Router::connect('/pedidos.html',
		array(
			'controller'=>'orders',
			'action'=>'index',
		)
	);
    //Solicitações
    //---------------------------
    //Analisar solicitações
    Router::connect('/analisar-solicitacoes.html',
		array(
			'controller'=>'solicitations',
			'action'=>'analyze',
		)
	);
    //Analisar solicitações
    Router::connect('/minhas-solicitacoes.html',
		array(
			'controller'=>'solicitations',
			'action'=>'index',
		)
	);
    //Fazer Solicitação
    Router::connect('/fazer-solicitacao.html',
		array(
			'controller'=>'solicitation_items',
			'action'=>'index',
		)
	);
    //Fazer Solicitação
    Router::connect('/finalizar-solicitacao.html',
		array(
			'controller'=>'cart_items',
			'action'=>'index',
		)
	);    
    //Visualizar solicitação
    Router::connect('/solicitacao-:id.html',
		array(
			'controller'=>'solicitations',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Visualizar classe do item
    Router::connect('/classe-do-item-:id.html',
		array(
			'controller'=>'item_classes',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Visualizar PNGC do item
    Router::connect('/pngc-do-item-:id.html',
		array(
			'controller'=>'pngc_codes',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Visualizar grupo de gastos
    Router::connect('/grupo-de-gastos-:id.html',
		array(
			'controller'=>'expense_groups',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Visualizar Unidade de medida
    Router::connect('/unidade-de-medida-:id.html',
		array(
			'controller'=>'measure_types',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Visualizar Categoria do insumo
    Router::connect('/categoria-insumo-:id.html',
		array(
			'controller'=>'input_categories',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);
    //Visualizar subcategoria de insumo
    Router::connect('/subcatgoria-insumo-:id.html',
		array(
			'controller'=>'input_subcategories',
			'action'=>'view',
		),
        array(
            'pass'=>array('id'),
            'id'=>'[0-9]+'
        )
	);

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();
	Router::parseExtensions('json', 'pdf');
/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
