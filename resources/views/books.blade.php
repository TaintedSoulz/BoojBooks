@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Add Books') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('books.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <select id="books-search-select" class="form-control" multiple="multiple" name="books[]" data-placeholder="Choose books to add to the list" required="required"></select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Add selected to list</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">{{ __('List of Books') }}</div>

                    <div class="card-body">
                        <table id="books-table">
                            <thead>
                            <th class="no-sort"></th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Published Date</th>
                            <th class="no-sort"></th>
                            </thead>
                            <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td class="row justify-content-center"><a href="{{ $book->url }}"><img src="{{ $book->cover_small }}" class="img-fluid"></a></td>
                                    <td data-search="{{ $book->title }}"><a href="{{ $book->url }}">{{ $book->title }}</a></td>
                                    <td data-search="{{ $book->author }}"><a href="{{ $book->author_url }}">{{ $book->author }}</a></td>
                                    <td>{{ $book->publish_date }}</td>
                                    <td><button class="btn btn-danger" type="button" onclick="window.location.href='{{ route('books.destroy', $book->id) }}'">Remove</button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#books-table').DataTable({
                "order": [],
                "columnDefs": [ {
                    "targets"  : 'no-sort',
                    "orderable": false,
                }]
            });

            $('#books-search-select').select2({
                minimumInputLength: 3,
                minimumResultsForSearch: 50,
                ajax: {
                    url: 'http://openlibrary.org/search.json',
                    dataType: 'json',
                    delay: 1000,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (bookData) {
                        let data = $.map(bookData.docs, function (obj) {
                            return {
                                id: obj.cover_edition_key,
                                text: obj.title +
                                    (obj.author_name !== undefined ? " By " + obj.author_name[0] : "") +
                                    " Published: " + obj.first_publish_year
                            };
                        });
                        console.log(data);
                        return {
                            results: data
                        };
                    }
                }
            });
        });
    </script>
@endpush
