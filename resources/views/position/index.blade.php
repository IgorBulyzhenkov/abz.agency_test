@extends('index')

@section('content')
    <a href="{{ route('users') }}" class="btn btn-secondary" style="margin-bottom: 20px">Back</a>
    <div class="table-container">
        <table id="tablePosition" class="table table-striped table-dark custom-table" style="min-height: 625px; margin: 0;">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
            </tr>
            </thead>
            <tbody id="positionTableBody">

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    @include('position.scripts.scripts-positions')
@endpush
