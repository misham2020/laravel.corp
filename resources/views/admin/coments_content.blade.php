
@if($comments)
	<div id="content-page" class="content group">
				            <div class="hentry group">
				                <h2>Добавленные комментарии</h2>
				                <div class="short-table white">
				                    <table style="width: 100%" cellspacing="0" cellpadding="0">
				                        <thead>
				                            <tr>
				                                <th class="align-left">ID</th>
				                                <th>Имя</th>
				                                <th>Текст</th>				                                
				                                <th>статья</th>				                                
				                                <th>Дествие</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            
											@foreach($comments as $comment)
											<tr>
				                                <td class="align-left">{{$comment->id}}</td>
				                                <td class="align-left">{{($comment->name)?($comment->name):($comment->user->name)}}</td>
				                                <td class="align-left">{{\Illuminate\Support\Str::limit($comment->text,150)}}</td>				                        
				                                <td>{{$comment->article->title}}</td> 
				                                <td>
												{!! Form::open(['url' => route('admin.comments.destroy',['comment'=>$comment->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
												    {{ method_field('DELETE') }}
												    {!! Form::button('Удалить', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
												{!! Form::close() !!}
												</td>
											 </tr>	
											@endforeach	
				                           
				                        </tbody>
				                    </table>
				                </div>
								
				            </div>
				            <!-- START COMMENTS -->
				            <div id="comments">
				            </div>
				            <!-- END COMMENTS -->
				        </div>
@else <h1>Комментариев нет</h1>
@endif