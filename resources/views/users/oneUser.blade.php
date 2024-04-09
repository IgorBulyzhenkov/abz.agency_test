@extends('index')

@section('content')

    <a href="{{ route('users') }}" class="btn btn-secondary" style="margin-bottom: 20px">Back</a>
    <div class="row">
        <div class="col-12">
            <div class="card d-flex" style="padding: 10px;flex-direction: row;justify-content: space-around;min-height: 400px">
                <img class="img" id="photo" alt="user-photo" width="250" height="250" src="/images/nonprofile.webp"/>

                <ul class="list-group">
                    <li class="list-group-item d-flex" style="justify-content: space-between">
                        <strong>ID :</strong>
                        <p id="id"></p>
                    </li>
                    <li class="list-group-item d-flex" style="justify-content: space-between">
                        <strong>NAME :</strong>
                        <p id="name"></p>
                    </li>
                    <li class="list-group-item d-flex" style="justify-content: space-between">
                        <strong>EMAIL :</strong>
                        <a href="" id="email"></a>
                    </li>
                    <li class="list-group-item d-flex" style="justify-content: space-between">
                        <strong>PHONE :</strong>
                        <a id="phone" href=""></a>
                    </li>
                    <li class="list-group-item d-flex" style="justify-content: space-between">
                        <strong>POSITION :</strong>
                        <p id="position"></p>
                    </li>
                    <li class="list-group-item d-flex" style="justify-content: space-between">
                        <strong>CREATED :</strong>
                        <p id="registration_timestamp"></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('users.scripts.scripts-one_user')
@endpush
