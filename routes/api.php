<?php


//POST Crear producto
//URL: /inventario/crear {"producto":{"sku":"9786076345696" ,"tienda":"10", "nombre":"producto", "precio":10,  "stock":"10"}}
//Respuesta: 201 {"producto":{"producto_id":1,"tienda":"10","sctok":"10"}}

Route::post('/inventario/crear', 'App\Http\Controllers\inventario@crear');

//POST Agregar Stock
//URL: /inventario/add {"producto":{"tienda":"10", "sku":"9786076345696",  "stock":"10"}}
//Respuesta: 201 {"producto":{"id":"10"}}

Route::post('/inventario/add', 'App\Http\Controllers\inventario@agregar');

//POST Remover Stock
//URL: /inventario/remove {"producto":{"tienda":"10", "sku":"9786076345696",  "stock":"10"}}
//Respuesta: 201 {"producto":{"id":"10"}}

Route::post('/inventario/remove', 'App\Http\Controllers\inventario@remover');

//GET Retornar inventario tienda
//URL: /inventario/tienda/{id}
//Respuesta: 201 {"producto":3,"nombre":"producto3","precio":10,"stock":310},{"producto":1,"nombre":"producto","precio":10,"stock":310}

Route::get('/inventario/tienda/{id}', 'App\Http\Controllers\inventario@inventarioTienda');

//GET Retornar stock producto
//URL: /inventario/producto/{id}
//Respuesta: 201 {"tienda":10,"stock":310},{"tienda":11,"stock":310},{"tienda":12,"stock":310}

Route::get('/inventario/producto/{sku}', 'App\Http\Controllers\inventario@stockproducto');

//GET Retornar stock producto tienda
//URL: /inventario/producto/{sku}/tienda/{id}
//Respuesta: 201 {"tienda":10,"stock":310},{"tienda":11,"stock":310},{"tienda":12,"stock":310}

Route::get('/inventario/producto/{sku}/tienda/{id}', 'App\Http\Controllers\inventario@tiendaproducto');
