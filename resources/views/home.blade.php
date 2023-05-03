<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main id="to-do-task">
        <div class="container">
            <div class="add-task-container">
                <form action="{{route('store')}}" method="POST" autocomplete="off">
                    @csrf 
                    <div class="input-group">
                        <input type="text" name="content" class="input-add-task" placeholder="Add you new todo list">
                        <button type="submit" class="btn orange-btn"><i class="fa-sharp fa-solid fa-plus"></i></button>
                    </div>
                </form>

                @if(count($todolists))
                    <ul class="task-container mt-1 pd-1">
                        @foreach ($todolists as $todolist)                     
                            <li class="list-item">
                                <div class="task">
                                    <p class="task-content">{{$todolist->content}}</p>
                                    <form action="{{route('destroy', $todolist->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-trash"><i class="fas fa-light fa-trash"></i></button>
                                    </form>
                                </div>
                                <form method="POST" action="{{ route('change', $todolist->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $todolist->id }}">
                                        <input type="hidden" name="content" value="{{ $todolist->content }}">

                                        <div class="task">
                                            <select name="status">
                                                <option value="1" {{ $todolist->status == 1 ? 'selected' : '' }}>Incomplete</option>
                                                <option value="2" {{ $todolist->status == 2 ? 'selected' : '' }}>Complete</option>
                                            </select>
                                            <button type="submit" class="btn btn-edit"><i class="fas fa-regular fa-pen-to-square"></i></button>
                                        </div>
                                </form>
                                
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="task-container center mt-1 pd-1">No Tasks!</p>
                @endif


            </div>
            <?php $pending_todolists = $todolists->where('status', 1); ?>
            @if(count($pending_todolists))
                <div class="count-footer center">
                    You have {{ count($pending_todolists) }} pending tasks
                </div>
            @elseif(count($todolists)>0 && count($pending_todolists)==0)
                <div class="count-footer center">
                    You have complete all the tasks
                </div>
            @endif
        </div>
    </main>
</body>
</html>