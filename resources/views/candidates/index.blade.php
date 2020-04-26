@extends('layouts.master')

@section('content')
<style>
div.card {
    padding: 15px;
    margin-bottom: 20px;
    font-size: 14px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <form method="GET" action="{{ route('candidates.index') }}" id="searchFormId">
            @csrf

            <div class="form-group row">
                <div class="col-md-10">
                    <input id="search" type="text" placeholder="Search by name,email,location and cover letter" class="form-control" name="q">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="searchBtnId" onClick="searchCandidate();" type="button">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2 style="margin-top: 20px;margin-bottom: 20px;">Candidates</h2>
            <div id="candidateContent">
                @foreach ($candidates as $candidate)
                    <div class="card" style="border: 1px solid #e0e0e0;border-radius: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $candidate->name }} (<small>{{ $candidate->location }}</small>)</h5>
                            
                            <p class="card-text">{{ $candidate->cover_letter }}</p>
                            <button type="button" class="btn btn-primary modelBtnClass" data-id="{{ $candidate->uuid }}">More</button>
                        </div>
                    </div>
                @endforeach
            </div>            
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <b>Candidate Profile</b>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Profile</a></li>
                    <li><a data-toggle="tab" href="#menu1">Comments</a></li>
                    <li><a data-toggle="tab" href="#menu2">Resume</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
$(function(){
    $('.modelBtnClass').on('click', function(){
        var uuid = $(this).attr('data-id');
        
        if(uuid != ""){
            $.get('/candidates/' + uuid, function( data ) {
                $('#myModal').modal();
                $('#myModal div#myTabContent').html("");
                $('#myModal').on('shown.bs.modal', function(){
                    $('#myModal div#myTabContent').html(data);
                });

                $('#myModal').on('hidden.bs.modal', function(){
                    $('#myModal .modal-body').data('');
                });
            });
        }
    });
});

function searchCandidate() {
    $.ajax({
        method: "GET",
        url: "/candidates",
        data: $("#searchFormId").serialize()
    })
    .done(function( res ) {
        $("#candidateContent").html(res);
    });

    // $.get('/candidates/' + uuid, function( data ) {
    //     $('#myModal').modal();
    //     $('#myModal div#myTabContent').html("");
    //     $('#myModal').on('shown.bs.modal', function(){
    //         $('#myModal div#myTabContent').html(data);
    //     });

    //     $('#myModal').on('hidden.bs.modal', function(){
    //         $('#myModal .modal-body').data('');
    //     });
    // });
}
</script>
@endsection
