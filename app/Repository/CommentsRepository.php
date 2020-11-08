<?php

namespace App\Repository;

use App\Article;
use App\Comment;
use Illuminate\Support\Facades\DB;


class CommentsRepository extends Repository
{
   public $chaild = [];

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
    public function deleteComment($comment)
    {
        
        /* if(Gate::denies('destroy', $article)) {
           abort(403);
       }  */
     
        $comments = Comment::select('*')->get();


           foreach ($comments as $item) {
               if ($comment->id == $item->parent_id) {
                   array_push($this->chaild, $comment->id);
                   $chaild1 = $item->id;
                   
                   $comment->id = $chaild1;
                  
                   array_push($this->chaild, $chaild1);
                }
            } 
             $comment->delete();
            
       

            foreach ($this->chaild as $chaild) {
                DB::table('comments')->where('id', '=', $chaild)->delete();
            } 
          
              

        if ($comment->delete()) 
        {
            return ['status' => 'Материал удален'];
        } 
    }

}
