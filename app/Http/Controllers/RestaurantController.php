<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;

class RestaurantController extends Controller
{
    protected $db = null;
    protected $subcollection = null;

    public function __construct() {
        $client = new FirestoreClient(['projectId' => 'laravel-firestore-4b02e']);

        $this->db = $client->collection('Restaurant');
        $this->subcollection = $client->collectionGroup('menu_items');
    }

    public function groupQuery()
    {
        $access = new FirestoreClient(['projectId' => 'laravel-firestore-4b02e']);
        return $access->collectionGroup('menu_items')->where('name', '=', 'Japnese')->documents();
    }

    //create menu
    public function createMenu(Request $request)
    {
        //add will generate unique doc_id, while for set(), needs to pass a document id
        // $menu = $this->db->document('doc_id')->set([
        //     'name' => $request->name,
        //     'status' => $request->status
        // ]);

        $menu = $this->db->add([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json([
            "message" => "Menu created successfully."
        ]);

    }

    //get all menu
    public function index()
    {
        $data = $this->db->documents();
        $menu = [];
        
        foreach ($data as $key => $value) {
            //value->id(), return documentId
            if(array_key_exists('name', $value->data())) {
                $menu[$value->id()] = $value->data();
            }
        }
        
        return $menu;
    }

    //edit menu
    public function editMenu(Request $request)
    {
        $data = $this->db->document($request->id);
        $snapshot = $data->snapshot();
    
        $menuId = $snapshot->id();
        //$snapshot->data(), to get the data
        if($menuId == $request->id) {
            $updatedData = $this->db->document($menuId)->update([
                ['path' => 'name', 'value' => $request->name],
                ['path' => 'status', 'value' => $request->status]
            ]);

            return response()->json([
                "message" => "updated successfully"
            ]);
        }
    }

    //delete menu
    public function deleteMenu(Request $request)
    {
        $data = $this->db->document($request->id);
        $snapshot = $data->snapshot();

        $menuId = $snapshot->id();
        
        if($menuId == $request->id) {
            $this->db->document($menuId)->delete();

            return response()->json([
                "message" => "Deleted"
            ], 200);
        } else {
            return response()->json([
                "message" => "Menu not found"
            ], 404);
        }
    }

    //get all menuItems
    public function getAllItems()
    {
        $menus = $this->db->documents();

        $menuItems = [];

        foreach ($menus as $key => $value) {
            $items = $this->db->document($value->id())->collection('menu_items')->documents();
            foreach ($items as $item) {
                $menuItems[$item->id()] = $item->data();
            }
        }

        return $menuItems;
    }

    //create menuItems inside menu
    public function createItem(Request $request)
    {
        $menu = $request->menu;

        $documents = $this->db->where('name', '=', $menu)->documents();

        foreach ($documents as $key => $value) {
            $createdItem = $this->db->document($value->id())->collection('menu_items')->add([
                'name' => $request->name,
                'status' => $request->status,
                'price' => $request->price,
            ]);
    
            return response()->json([
                'message' => 'Item created successfully.'
            ]);
        }
        
    }

    //delete item
    public function deleteItem(Request $request)
    {
        $data = $this->subcollection->where('name', '=', 'susi')->documents();

        foreach ($datas as $key => $value) {
            $name = $value->data()['name'];
            if($name == $request->name) {
                $this->db->document($name)->delete();
                return response()->json([
                    "message" => "Deleted"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Menu not found"
                ], 404);
            }
        }
    }
}

