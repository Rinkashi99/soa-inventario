<?php

namespace App\Http\Controllers;

use App\Models\productos;
use App\Models\productos_tienda;
use Illuminate\Http\Request;

class inventario extends Controller
{
    public function crear(Request $request){
        $producto = productos::where('sku',$request->input('producto')['sku'])->first();
        if(!isset($producto)){
        $producto = new productos;
        $producto->nombre = $request->input('producto')['nombre'];
        $producto->precio = $request->input('producto')['precio'];
        $producto->sku = $request->input('producto')['sku'];
        $producto->save();
        $producto_tienda = new productos_tienda;
        $producto_tienda->producto_id = $producto->sku;
        $producto_tienda->tienda_id = $request->input('producto')['tienda'];
        $producto_tienda->stock = $request->input('producto')['stock'];
        $producto_tienda->save();
        return response()->json([
            'producto' => ['sku' => $producto->sku, 'tienda' => $producto_tienda->tienda_id, 'stcok' =>  $producto_tienda->stock]
        ],
        201);
        }else{
            return response()->json([
                "Producto ya registrado"
            ],
            500);
        }
    }

    public function agregar(Request $request){
        $producto_tienda = productos_tienda::where('tienda_id', $request->input('producto')['tienda'])
        ->where('producto_id',$request->input('producto')['sku'])
        ->first();
        if(isset($producto_tienda)){
            $producto_tienda->stock += $request->input('producto')['stock'];
            $producto_tienda->save();
            return response()->json([
                'producto' => ['sku' => $producto_tienda->producto_id, 'tienda' => $producto_tienda->tienda_id, 'stock' =>  $producto_tienda->stock]
            ],
            201);
        }else{
            $producto = productos::where('sku',$request->input('producto')['sku'])->first();
            if($producto){
                $producto_tienda = new productos_tienda;
                $producto_tienda->producto_id = $producto->sku;
                $producto_tienda->tienda_id = $request->input('producto')['tienda'];
                $producto_tienda->stock = $request->input('producto')['stock'];
                $producto_tienda->save();
                return response()->json([
                    'producto' => ['sku' => $producto_tienda->producto_id, 'tienda' => $producto_tienda->tienda_id, 'stock' =>  $producto_tienda->stock]
                ],
                201);
            }
        }
        return response()->json(
            0,
        404);
    }

    public function remover(Request $request){
        $producto_tienda = productos_tienda::where('tienda_id', $request->input('producto')['tienda'])
        ->where('producto_id',$request->input('producto')['sku'])
        ->first();
        if($producto_tienda){
            if($producto_tienda->stock >= $request->input('producto')['stock']){
                $producto_tienda->stock -= $request->input('producto')['stock'];
                $producto_tienda->save();
                return response()->json([
                    'producto' => ['sku' => $producto_tienda->producto_id, 'tienda' => $producto_tienda->tienda_id, 'stock' =>  $producto_tienda->stock]
                ],
                201);
            }
            return response()->json([
                'producto' => ['sku' => $producto_tienda->producto_id, 'tienda' => $producto_tienda->tienda_id, 'stock' =>  $producto_tienda->stock]
            ],
            406);
        }
        return response()->json(
            0,
        404);
    }

    public function inventarioTienda($id){
        $productos_tienda = productos_tienda::where('tienda_id', $id)->get();
        if(count($productos_tienda) > 0){
            foreach($productos_tienda as $key => $productos){
                $p[$key]['sku'] = $productos->producto->sku;
                $p[$key]['nombre'] = $productos->producto->nombre;
                $p[$key]['stock'] = $productos->stock;
                $p[$key]['precio'] = $productos->producto->precio;
            }
            return response()->json(
                $p,
            201);
        }
        return response()->json(
            0,
        404);
    }
    public function stockproducto($sku){
        $productos_tienda = productos_tienda::where('producto_id', $sku)->get();
        if(count($productos_tienda) > 0){
            foreach($productos_tienda as $key => $productos){
                $p[$key]['tienda'] = $productos->tienda_id;
                $p[$key]['stock'] = $productos->stock;
            }
            return response()->json(
                $p,
            201);
        }
        return response()->json(
            0,
        404);
    }

    public function tiendaproducto($sku,$id){
        $producto = productos_tienda::where('tienda_id', $id)->where('producto_id', $sku)->first();
        if(isset($producto)){
                $p['nombre'] = $producto->producto->nombre;
                $p['stock'] = $producto->stock;
                $p['precio'] = $producto->producto->precio;
            return response()->json(
                $p,
            201);
        }
        return response()->json(
            0,
        404);
    }

}
