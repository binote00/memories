$(document).ready(function($)
{
    /*$('body').bootstrapMaterialDesign();*/

    $('.tag-del, .tag-cancel, .btn-modif').hide();

    $('.table').DataTable( {
        language: {
            processing:     "Traitement en cours...",
            search:         "Rechercher&nbsp;:",
            lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
            info:           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty:      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix:    "",
            loadingRecords: "Chargement en cours...",
            zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable:     "Aucune donnée disponible dans le tableau",
            paginate: {
                first:      "Premier",
                previous:   "Pr&eacute;c&eacute;dent",
                next:       "Suivant",
                last:       "Dernier"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        },
        "pageLength": 50,
        fixedHeader: {
            header: true,
            footer: true
        },
        /*responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details de '+data[1]+' '+data[2];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }*/
    } );

    /*var height = $(window).height();
    var width = $(window).width();
    $.ajax({
        url: '../memories/app/g_screen.php',
        type: 'post',
        data: { 'width' : width, 'height' : height, 'recordSize' : 'true' },
        success: function(response) {
            alert(response[0].width + ' ' + response[0].height);
            $("body").html(response);
        }
    });*/

    /**
     * Auto-completion du champ de recherche
     */
    $('#nav-search').on('keyup', function(){
        $('#search-tags').empty();
        var id = $('#sess-id').html();
        if(id.length > 0){
            $.ajax({
                url: '../memories/app/a_tag_get.php',
                type: 'post',
                data: {id : id},
                dataType: 'json',
                success: function (data) {
                    for(var li in data){
                        $('#search-tags').append("<option>" + data[li].tag_name + "</option>");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status + " " + thrownError);
                }
            });
        };
    });

    /*$('#nav-search').on('keyup', function(){
        var search = $(this).val();
        if($('#sess-id').length > 0 && search.length > 1){
            var id = $('#sess-id').html();
            $.ajax({
                url: '../memories/app/a_tag_search.php',
                type: 'post',
                data: {id : id, search : search},
                success: function (data) {
                    console.log(data);
                    $('#nav-search').val(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status + " " + thrownError);
                }
            });
        };
    });*/

    /**
     * Vérification de la taille maximale des fichiers uploadés avec affichage du modal d'alerte
     */
    $("input:file").on('change', function(){
        if($(this).get(0).files.length > 0){
            var fileSize = $(this).get(0).files[0].size;
            if(fileSize > 2097152){
                $(this).val('');
                $('#modal-alert-img-size').modal("show");
            }
        }
    });

    $('#event_type').change(function(e){
        var choice = $(this).val();
        if(choice != ''){
            $.ajax({url: '../memories/app/g_event_add.php?event_type='+choice,
                contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",
                success: function(data)
                {
                    console.log(data);
                    $('#events').html(data);
                },
                error: function (xhr,ajaxOptions,thrownError) {
                    alert(xhr.status + " "+ thrownError);
                }});
            if(choice == 2) {
                $.ajax({
                    url: '../memories/app/g_images_show.php',
                    contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",
                    success: function (data) {
                        console.log(data);
                        $('#o_img').html(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }
                });
            }else if(choice == 1){
                    $.ajax({url: '../memories/app/g_messages_show.php',
                        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",
                        success: function(data)
                        {
                            console.log(data);
                            $('#o_img').html(data);
                            CKEDITOR.replace('ckeditor');
                        },
                        error: function (xhr,ajaxOptions,thrownError) {
                            alert(xhr.status + " "+ thrownError);
                        }});
            }else{
                $('#o_img').empty();
            }
        }
    });

    $('.modal-js').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('.modal-title').html(button.data('title'));
        $('.modal-body').html(button.data('body'));
        $('.modal-footer').html(button.data('footer'));
    });


    /**
     *  Images
     */

    $('#img-prec').on('click', function(){
        $.ajax({url: '../memories/app/a_move_offset.php?move=-1',
            success: function(data)
            {
                console.log('offset : ' + data);
            },
            error: function (xhr,ajaxOptions,thrownError) {
                console.log(xhr.status + " "+ thrownError);
            }});
    });

    $('#img-next').on('click', function(){
        $.ajax({url: '../memories/app/a_move_offset.php?move=1',
            success: function(data)
            {
                console.log('offset : ' + data);
            },
            error: function (xhr,ajaxOptions,thrownError) {
                console.log(xhr.status + " "+ thrownError);
            }});
    });

    $('#chk-img-del').on('click', function(){
        var check_value;
        var check = $(this).prop("checked");
        if(check){
            check_value = 1;
        }else{
            check_value = 0;
        }
        $.ajax({url: '../memories/app/a_chk_img_del.php?chk=' + check_value,
            success: function()
            {
                window.location.replace("https://www.aubedesaigles.net/memories/index.php?view=images");
            },
            error: function (xhr,ajaxOptions,thrownError) {
                console.log(xhr.status + " "+ thrownError);
            }});
    });

    /**
     *  CK-Editor
     */

    $('.ck-inline').on('click', function(){
        $('.btn-modif').hide();
        var tr = $(this).closest('tr');
        var btn = tr.find('.btn-modif');
        btn.show();
        /*tr.on('blur', function(){
            $(this).css('background-color', 'red');
            alert('tata');
            btn.hide();
        })*/
    });

    /**
     *  Message
     */

    $('.btn-modif').on('click', function(){
        $(this).hide();
        var tr = $(this).closest('tr');
        var idM = tr.find('.text-hide').html();
        var textM = tr.find('.ck-inline').html();
        $.ajax({
            url: '../memories/app/a_message_mod.php',
            type: 'post',
            data: {id : idM, message : textM},
            success: function (data) {
                if(data){
                    $('#alerts').html(data);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status + " " + thrownError);
            }
        });
    });

    $('select').on('click', function(){
        $('.btn-modif').hide();
    });

    /**
     *  Tags
     */

    $('.mem-tag').on('click', function(){
        $('.btn-modif').hide();
        var div = $(this).closest('div');
        var btn_del = div.find('.tag-del').show();
        var btn_cancel = div.find('.tag-cancel').show();
        //var border = tr.find('.mem-tag-border').addClass('border border-danger');
        div.addClass('border border-danger');
        btn_cancel.click(function(){
            btn_del.hide();
            btn_cancel.hide();
            div.removeClass('border border-danger');
        })
    });

    $('.tag-del').on('click', function(){
        var div = $(this).closest('div');
        var id = div.find('.hide-tag-id').html();
        var redirect = div.find('.hide-redirect').html();
        $.ajax({
            url: '../memories/app/a_taglink_del.php',
            type: 'post',
            data: {id : id, redirect : redirect},
            success: function (data) {
                div.remove();
                $('#alerts').html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status + " " + thrownError);
            }
        });
    });

    $('.mem-note').on('click', function(){
        $(this).html();
    });
});