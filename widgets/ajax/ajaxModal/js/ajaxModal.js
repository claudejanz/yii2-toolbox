/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
//we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
    $(document).on('click', '.showModal', function (event) {
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        var modal = $('#cjModal');
        if (!modal.data('bs.modal').isShown) {
            modal.modal('show');
        }
        modal.data('target', $(this));
        var jqxhr = $.ajax($(this).data('url'), {dataType: 'json'})
                .done(function (data) {
                    if (data.error == 1) {
                        modal.modal('hide');
                        alert(data.message);
                    } else {
                        if (data.message) {
                            alert(data.message);
                        }
                        modal.find('#cjModalContent').html(data);
                    }

                })
                .fail(function (data) {
                    if (data.responseJSON) {
                        alert(data.responseJSON.message);
                    } else if (data.responseText) {
                        alert(data.responseText);
                    } else {
                        console.log(data);
                    }
                })
                .always(function () {
//                    alert("complete");
                });
        //dynamiclly set the header for the modal
        $('#cjModalHeaderTitle').html('<h4>' + $(this).data('title') + '</h4>');
        event.stopPropagation();
        event.preventDefault();
    });
});
