<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Chat extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

    protected $table = 'chats';


    protected $fillable = ['chat', 'job_id', 'sender_id', 'reciever_id','created_at','updated_at'];
  
}