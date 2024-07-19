@if(count($questions) > 0 )
    <form id="form-to" action="{{ route('admin.questions.authoring.relocate.questions') }}" method="post">
        @csrf
        <div class="card p-2">
            <table id="questions" class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Questions</th>
                    <th><input type="checkbox" name="" id="check-all"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$question->title}}</td>
                        <td><input class="selection" type="checkbox" name="question_ids[]" value="{{$question->id}}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card border-info">
            <div class="card-header border-info">
                <h4>Destination</h4>
            </div>
            <div class="card-body">
                <div class="row pb-3 pt-2">
                    <div class="col-12 col-md-6 col-lg-5 col-xl-5">
                        <div class="form-group">
                            <label for="subject_id">Move to Paper:</label>
                            <select class="form-control form-select" name="subject_id" id="subject_to_id"
                                    required>
                                <option value="">Select Paper</option>
                                @foreach(App\Models\Subject::all() as $subject)
                                    <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 col-xl-5">
                        <div class="form-group">
                            <label for="topic_id">Move to Subject:</label>
                            <select class="form-control form-select" name="topic_id" id="topic_to_id"
                                    required>
                                <option value="">Select Subject</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 col-xl-2">
                        <input type="submit" class="btn btn-info text-light mt-4" value="Move"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
@else
@endif
