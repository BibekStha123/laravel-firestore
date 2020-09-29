<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
        $db = new FirestoreClient(['projectId' => 'laravel-firestore-4b02e']);
        $data = $db->collectionGroup('menu_items')->where('status', '=', 'active')->documents();
        dd($data);
        // dd($data);
        //create a document, use add instead of set to generate unique doc_id
        // $store = $db->collection('Restaurant');
        // $res = $store->add([
        //         'name' => 'Korean',
        //         'status' => 'active',
        //         'addons' => ['d', 'b', 'c'],
        //         'items' => [
        //                 'salad' => ['name' => 'salad', 'price' => '190'],
        //                 'vegee' => ['name' => 'vegee', 'price' => '120']
        //         ]
        // ]);

        //get all the documents of restaurant with 'a' in array [addons].
        // $store = $db->collection('Restaurant')->where('addons', 'array-contains', 'a')->documents();
        // dd($store);
        
        // $store = $db->collection('Restaurant')->where('items', '=', 'vegee')->documents();
        // dd($store);

        //get all documents of collection
        // $datas = $db->collection('Users')->documents();
        
        //delete document
        // $delete = $db->collection('Users')->document('Mia')->delete();
        // dd($delete);

        // create sub collections
        // $res = $db->collection('Users')->document('Amrit')->collection('messages')->document('home');
        // dd($res->set([
        //     'name' => 'mom',
        //     'message' => 'where are you?'
        // ]));

        
        // $a = $db->collection('Users')->document('Amrit')->collection('contact')->document('office');
        // $a->set([
        //     'name' => 'office',
        //     'number' => '5576384'
        // ]);

        //store into sub-collection
        // $store = $db->collection('Users')->document('Amrit')->collection('messages')->document('friends');
        // $res = $store->set([
        //     'name' => 'binod',
        //     'message' => 'how are you?'
        // ]);
        // dd($res);

        // $datas = $db->collection('Users')->document('Amrit')->collection('messages')->documents();
        // foreach ($datas as $data) {
        //     dd($data['name']);
        // }

        //update
        // $doc = $db->collection('Users')->document('Amrit');
        // dd($doc);
        // $doc->update([
        //         ['path' => 'profession', "value" => FieldValue::arrayRemove(['professor'])]
        // ]);

});


Route::get('/firestore', 'App\Http\Controllers\FireController@index');
