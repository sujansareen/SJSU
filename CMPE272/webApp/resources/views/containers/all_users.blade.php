@extends('layouts.app')
@section('content')
    <br />
    <div class="container">
        <div class="alert alert-primary" id="founduser" style="display: none;" role="alert"></div>
        <div class="alert alert-danger" id="erroruser" style="display: none;" role="alert"> Error </div>
            <div class="table-responsive">
                <table id="user-table" class="table" style="display: none;">
                    <thead>
                    <tr>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Email</th>
                        <th scope="col">Cell phone</th>
                        <th scope="col">Home phone</th>
                        <th scope="col">Home address</th>
                    </tr>
                    </thead>
                    <tbody id="user-table-body">
                    </tbody>
                </table>
            </div>
            {{--   user row template --}}
            <table class="table" style="display: none;" >
                <tr id="userRowTemplate" >
                    <td class="first-name" ></td>
                    <td class="last-name" ></td>
                    <td class="email" ></td>
                    <td class="cell-phone" ></td>
                    <td class="home-phone" ></td>
                    <td class="home-address" ></td>
                </tr>
            </table>
        <br />
        <script>
            var $alertFound =  $("#founduser");
            var $alertError =  $("#erroruser");
            var $userTable  =  $('#user-table');
            //=====Search
            function renderUserRow(data){
                if(data && data.first_name){
                    var $row = $('#userRowTemplate').clone();
                    $row.attr('id', '');
                    $row.attr('data-id', data.id||'');
                    $row.find('.first-name').text(data.first_name||'');
                    $row.find('.last-name').text(data.last_name||'');
                    $row.find('.email').text(data.email||'');
                    $row.find('.cell-phone').text(data.cell_phone||'');
                    $row.find('.home-phone').text(data.home_phone||'');
                    $row.find('.home-address').text(data.home_address||'');
                    $row.show();
                }
                return $row;
            }
            axios.get('/api/user/all_companys', { })
                .then(function (response) {
                    window.scrollTo(0,0);
                    var users = response.data;
                    if(users.length){
                        var $rows = users.map(renderUserRow);
                        $('#user-table-body').html($rows);
                        $userTable.show();
                        $alertFound.show();
                        $alertFound.text("Found: " + users.length + " users" );
                    } else {
                        $userTable.hide();
                        $alertFound.text('No One Found');

                    }
                    setTimeout(function(){
                        $alertFound.hide();
                        $alertFound.text('');
                    },4000)
                })
                .catch(function (error) {
                    console.log(error);
                    $alertError.show();
                    window.scrollTo(0,0);

                    setTimeout(function(){
                        $alertError.hide();
                    },4000)
                });
        </script>
    </div>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



