@extends('index')

@section('content')
    <button type="button" id="token" class="btn btn-outline-warning" style="display: none; margin-bottom: 20px">Get
        Token
    </button>
    <button type="button" id="add" class="btn btn-outline-secondary" style="display: block; margin-bottom: 20px">Add
    </button>

    <div class="backdrop" id="backdrop">
        <div class="container-form" id="modal_form">
            <div class="col-12 col-md-6">
                <h2 style="font-size: 20px; font-weight: 700" class="general_title">ADD USER</h2>
                <div class="position-absolute close_modal" id="close">x</div>
                <div>
                    <div class="col-12">
                        <div class="card">
                            <form novalidate action="{{ route('users.store') }}" id="form_user"
                                  class="d-flex flex-column align-items-end">

                                <div class="col-12 mt-0">
                                    <div class="form-group">
                                        <label class="w-100 m-b-10 position-relative" for="name">
                                            Name

                                        </label>
                                        <input class="form-control" type="text" name="name" placeholder="Name"
                                               id="name">
                                        <span class="position-absolute w-100"
                                              style="color: red;
                                            font-size: 13px;
                                            bottom: -5px;
                                            left: 15px;" id="span_name"></span>
                                    </div>
                                </div>

                                <div class="col-12 mt-0">
                                    <div class="form-group">
                                        <label class="w-100 m-b-10 position-relative" for="email">
                                            Email
                                        </label>
                                        <input class="form-control" type="email" name="email"
                                               placeholder="primery@email.com" id="email">
                                        <span class="position-absolute w-100"
                                              style="color: red;
                                            font-size: 13px;
                                            bottom: -5px;
                                            left: 15px;" id="span_email"></span>
                                    </div>
                                </div>

                                <div class="col-12 mt-0">
                                    <div class="form-group ">
                                        <label class="w-100 m-b-10 position-relative" for="phone">
                                            Phone
                                        </label>
                                        <input class="form-control" type="tel" name="phone"
                                               placeholder="+380_________" id="phone" maxlength="13">
                                        <span class="position-absolute w-100"
                                              style="color: red;
                                            font-size: 13px;
                                            bottom: -5px;
                                            left: 15px;" id="span_phone"></span>
                                    </div>
                                </div>

                                <div class="col-12 mt-0">
                                    <div class="mb-3">
                                        <label class="form-label" for="formFile">
                                            Photo
                                        </label>
                                        <input class="form-control" type="file" name="photo" id="formFile">
                                        <span class="position-absolute w-100"
                                              style="color: red;
                                            font-size: 13px;
                                            bottom: -5px;
                                            left: 15px;" id="span_photo"></span>
                                    </div>
                                </div>

                                <div class="col-12 mt-0">
                                    <div class="form-group ">
                                        <label class="w-100 m-b-10 position-relative">
                                            Position
                                            <select class="w-100 form-control js-example" name="position">
                                                @foreach($position as $el)
                                                    <option class="w-100 input" type="text" name="position"
                                                            value="{{$el->id}}">{{$el->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-2 mb-2 mr-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table id="myTable" class="table table-striped table-dark custom-table" style="min-height: 625px; margin: 0;">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Position</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="myTableBody">

            </tbody>
        </table>
    </div>
    <div style="display: flex;
                justify-content: space-between;">
        <nav aria-label="Page navigation example" style="display: flex;
                                                         align-items: center;">
            <ul class="pagination m-0" id="list_pagination">
                <li class="page-item">
                    <a class="page-link" href="" id="prev">Prev</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="" id="next">Next</a>
                </li>
            </ul>
        </nav>
        <div class="container_total">
            <p class="text_total">Total Users:</p>
            <p class="int_total" id="total"></p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/modals.js"></script>
    @include('users.scripts.scripts-users')
    @include('users.scripts.scripts-token')
    <script type="module">
        $(document).ready(function () {
            $('.js-example').select2();
        });
    </script>
    @include('users.scripts.add-users')
@endpush
