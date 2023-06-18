//Route
Route::get('/search',[SearchController::class, 'search'])->name('search');

//Blade

<form action="{{ route('jobList') }}" method="GET">
                            <div class="search input-group">
                                <input class="form-control" type="text" name="search" id="search-input"
                                    placeholder="Start Searching Your Dream Job">
                                <button class="btn btn-primary">Search</button>
                            </div>
                        </form>
                        <div class="search-suggession mb-3">
                            <ul id="search-results"></ul>
                        </div>

//controller

<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        try {

            $results = Job::where('title', 'like', "%{$query}%")
                ->orWhere('location', 'like', "%{$query}%")
                ->limit(10)
                ->get();
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during the search.'], 500);
        }
    }
}


// Javascript

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var typingTimer;
        var doneTypingInterval = 500; // Adjust the delay as needed

        $('#search-input').on('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $('#search-input').on('keyup', function() {
            if ($('#search-input').val() === '') {
                $('#search-results').empty();
            }
        });

        function doneTyping() {
            var query = $('#search-input').val();
            if (query.length >= 3) {
                $.get('{{ route('search') }}', {
                    query: query
                }, function(results) {
                    $('#search-results').empty();
                    $.each(results, function(index, job) {
                        var url = '{{ route('show_job', ':jobId') }}';
                        url = url.replace(':jobId', job.id);
                        var listItem = '<li><a href="' + url + '">' + job.title + '</a></li>';
                        $('#search-results').append(listItem);
                    });
                });
            } else {
                $('#search-results').empty();
            }
        }
    });
</script>
