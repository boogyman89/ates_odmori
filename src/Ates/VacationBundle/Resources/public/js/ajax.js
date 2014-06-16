$(document).ready(function() {
    
    function getState( s )
    {
        if('pending' == s)
        {
            state = 1;
        }
        else if('approved' == s)
        {
            state = 2;
        }
        else
        {
            state = 'all';
        }
        
        return state; 
    }
     
  //find requests  
  $('#filterRequestButton').on('click', function(){
     //rename title Pending Request to Request
     $('.requestsTitle').text('Requests');
     
     //get name from worker name
     workerName = $('#requestWorkerName').val();
     workerLastName = $('#requestWorkerLastName').val();
     state = getState( $('#requestsFilterProfile').val() );
     
     if('' == workerName && '' == workerLastName )
    {
        alert('Both field for search are empty!');
    }
    else
    {
        $.post(EmpoloyeeVacation.routes.ajax_request_find_requests,{ name: workerName, last_name: workerLastName, filter: state },  function(data) {

            if(data !== '')
            {
               $('#requestResults').html(data);
            }
            else
            {
                 $('#requestResults').html('<h3>There is no requests for that user OR there is no user with that name!</h3>');
            }
         });
    }
  });
  
  
  //find users
  $('#findUsersButton').on('click', function(){
     
     //get name from worker name
     workerName = $('#searchUserName').val();
     workerLastName = $('#searchUserLastName').val();

    $.post(EmpoloyeeVacation.routes.ajax_request_find_user, { name: workerName, last_name: workerLastName },  function(data) {
        //alert(data);
        if(data !== '')
        {
           $('#usersResult').html(data);
        }
        else
        {
           $('#usersResult').html('<h3>There is no user with that name!</h3>');
        }
     });

  });
  
  
  
   //filter requests on profile page
   $("#requestsFilterProfile").on('change', function(){
      //alert (EmpoloyeeVacation.routes.ajax_find_user_request_base);
        
        var state = getState( $(this).val() );
        getUserRequests( state, 1 );
    });
    
   function getUserRequests( state, page )
   {
       $.get(EmpoloyeeVacation.routes.ajax_find_user_request_base + '/' + state + '/' + page, function(data){
            //alert(data);
            if(data !== '')
            {
               $('#userRequestResults').html(data);                
            }
            else
            {
                $('#userRequestResults').html('<h3>There is no request with selected status ('+state+')!</h3>');
            }
        });
   }
    
   //intersept pagerfanta request on prolfile page
   $(document).on('click', '.pagination ul li a', function(){
        
       var page = $(this).text();
       var state = getState( $("#requestsFilterProfile").val() );
             
        //if not a number
        if(isNaN(page))
        {
            //if is possible to go on clicked page
            if(!$(this).parent().hasClass('disabled'))
            {
                if($(this).parent().hasClass('next'))
                {
                    url = $(this).attr('href');
                    urlArr = url.split("/");
                    page = urlArr[urlArr.length - 1];
                }
                else if($(this).parent().hasClass('prev'))
                {
                    url = $(this).attr('href');
                    urlArr = url.split("/");
                    
                    if('all' == urlArr[urlArr.length - 1])
                        page = 1;
                    else
                        page = urlArr[urlArr.length - 1];
                }
            }            
        }
       
       var divWrapp = $(this).parent().parent().parent().parent();
       if(divWrapp.hasClass('pagerfantaProfile'))
       {
           getUserRequests( state, page );
       }
       else if(divWrapp.hasClass('pagerfantaPendingRequest'))
        {
            getPendingRequests( page );
        }
       else if(divWrapp.hasClass('pagerfantaSearchRequest'))
        {
            first_name = $('#requestWorkerName').val();
            last_name = $('#requestWorkerLastName').val();
            //alert(first_name + ' ' + last_name);
            getSearchRequests( page, state, first_name, last_name );
        }
       return false;
   });
   
   function getPendingRequests( page )
   {
       $.get(EmpoloyeeVacation.routes.ajax_get_pending_requests_base + '/' + page, function(data){
            //alert(data);
            if(data !== '')
            {
               $('#requestResults').html(data);                
            }
        });
   }
   function getSearchRequests( page, state, first_name, last_name )
   {
       $.post(EmpoloyeeVacation.routes.ajax_request_find_requests, {page: page, filter: state, name: first_name, last_name: last_name}, function(data){
            if(data !== '')
            {
               $('#requestResults').html(data);                
            }
            else
            {
                $('#requestResults').html('<h3>There is no request with selected status ('+state+')!</h3>');
            }
        });
   }
    
    
    

   
   $(document).on('click', '.showRequestInfo', function(){
        id = $(this).attr('id');
        
        $.post(EmpoloyeeVacation.routes.ajax_find_request_by_id, { id: id}, function(data){
           
            if(data !== '')
            {  
                $('#requestModal').html(data);
                $('#commentModal').modal('toggle');
            }
       });        
   });
   
   $(document).on('click', '.rejectRequestLink', function(){
        id = $(this).attr('id');
        $('#rejectRequestModal').modal('toggle');
        
        $('.confirmRejectRequestButton').click(function(){
            window.location.href = EmpoloyeeVacation.routes.reject_request_base + '/' + id;
        });
   });
   
    
   $(document).on('click', '.deleteHoliday', function(){
        id = $(this).attr('id');
        $('#confirmDeleteHolidayModal').modal('toggle');

        $('.confirmDeleteHolidayButton').click(function(){
            window.location.href = EmpoloyeeVacation.routes.delete_holiday_base + '/' + id;
        });
   });
   
   $(document).on('click', '.deleteUser', function(){
        id = $(this).attr('id');
        $('#userDeleteModal').modal('toggle');

        $('.confirmDeleteUserButton').click(function(){
            window.location.href = EmpoloyeeVacation.routes.delete_user_on_approving_base + '/' + id;
        });
   });
   
   
   
});