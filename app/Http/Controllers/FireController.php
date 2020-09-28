<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;

class FireController extends Controller
{
    protected $db = null;

    public function __construct() {
        $this->db = new FirestoreClient();
    }

    public function index()
    {
        //get single data
        $data = $this->db->collection('Users')->document('Amrit')->collection('messages')->document('friends');
        dd($data->snapshot()->data());
    }
}
