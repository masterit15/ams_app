jQuery(function ($) {
    if (('serviceWorker' in navigator) && ('PushManager' in window)) {
        navigator.serviceWorker.register('/bitrix/templates/app/js/sw.js')
            .then((reg) => {
            // регистрация сработала
                //console.log('Registration succeeded. Scope is ' + reg.scope);
            }).catch((error) => {
                console.log(error)
            });
    }else{
        alert('Не поддерживаются уведомления!')
    }
    $(document).pjax('a:not("[no-data-pjax]"), #demo-list li a', '#pjax-container', { fragment: '#pjax-container', "timeout": 5000 });
    $('#pjax-container').on('pjax:success', function () {
        return false;
    });
    $(document).on('pjax:start', function () {
        NProgress.start();
    });
    $(document).on('pjax:end', function (e) {
        let attr = $(e.relatedTarget).attr('no-data-pjax')
        if (typeof attr !== typeof undefined && attr !== false) {
            // console.log(typeof attr);
        }else{
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        }
        // $.pjax.reload({container:".wrapper"})
        initializePlugins()
        NProgress.done();
    });
    initializePlugins();
});
function initializePlugins() {
    $('input[name="arrFilter_ff[NAME]"]').attr('placeholder', 'По названию')
    $('input[name="arrFilter_DATE_CREATE_1"]').attr('placeholder', 'По дате от')
    $('input[name="arrFilter_DATE_CREATE_2').attr('placeholder', 'По дате до')
    $('form[name="arrFilter_form"] input').on('change', function(){
    $('input[name="set_filter"]').trigger('click')
        // $.ajax({
        //     type: "GET",
        //     url: $(this).attr('action'),
        //     data: $( this ).serialize(),
        //     beforeSend: function () {
        //         NProgress.start();
        //     },
        //     complete: function () {
        //         NProgress.done();
        //     },
        //     success: function (res) {
        //         let result = $(res).find('.document_list').html()
        //         $('.document_list').html('')
        //         console.log(result)
        //         // $('.document_list').html(result)
        //     },
        //     error: function (err) {
        //         mainToast(5000, "error", 'Ошибка загрузки!', err)
        //     }
        // });
    })
    // document_list
    const tl = gsap.timeline()
    // bottom nav
    function getDocHeight() {
        var D = document;
        return Math.max(
            D.body.scrollHeight, D.documentElement.scrollHeight,
            D.body.offsetHeight, D.documentElement.offsetHeight,
            D.body.clientHeight, D.documentElement.clientHeight
        );
    }

    let lastScrollTop = 0
    window.addEventListener('scroll', function(event){
        if ($(window).scrollTop() + $(window).height() === getDocHeight()) {
            $('#footer_nav').removeClass('active')
        } else {
            $('#footer_nav').addClass('active')
        }

        lastScrollTop = $(this).scrollTop();
    })

    function PrintDiv(block) {    
        let popupWin = window.open('', '_blank', 'width=1200,height=800')
        popupWin.document.open()
        popupWin.document.write('<html><body onload="window.print()">' + $(block).html() + '</html>')
        popupWin.document.close()
    }

    $('.print_btn').on('click', function(){
        let block = $(this).next('.block_to_print')
        PrintDiv(block)
    })

    $('.accordion_item_wrap').on('click', function(){
        let parrent = $(this).parent('.accordion_item')
        $('.accordion_item_content').hide(200)
        let list = $(parrent).children('ul.accordion_item_content')
        if(!$(parrent).hasClass('active')){
            $('.accordion_list li').removeClass('active')
            $(parrent).addClass('active')
            $(list).show(200)
            tl.to($(list), { opacity: 1, duration: 0.2})
        }else{
            tl.to($(list), { opacity: 0, duration: 0.2 })
            $(list).hide(200)
            $(parrent).removeClass('active')
        }
    })
    function initPopup(){

        $('.popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            }
        });
    }
    initPopup()
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">изображение #%curr%</a> не удалось загрузить.',
            titleSrc: function (item) {
                return item.el.attr('title') ? item.el.attr('title') : 'АМС г. Владикавказ';
            }
        }
    });
    // mmenu 
    $('body').removeAttr('class');
    $('#mobile-menu').removeAttr('class');
    let $icon = $('.mmenu_btn');
    $("#mobile-menu").remove()
    $icon.removeClass("active");
    $(".menu").after("<div id='mobile-menu'>").clone().appendTo("#mobile-menu");
    $("#mobile-menu").find("*").attr("style", "");
    let $menu = $("#mobile-menu").children("ul").removeClass("menu")
        .parent().mmenu({
            "extensions": [
                "position-right",
                'widescreen', 'theme-white', 'effect-menu-slide', 'pagedim-black'
            ],
            "navbar": {
                "title": 'АМС г. Владикавказ',
            },
            "counters": true,
        });
    let API = $menu.data('mmenu');
    if (API !== undefined) {
        $icon.on("click", function () {
            API.open();
        });
    }
    if($('.actual_item').length > 0){
        window.addEventListener('load', function () {
            tl.to('.actual_item', { scale: 1, opacity: 1, duration: 0.2, stagger: 0.1, ease: "elastic" })
        })
    }
    // right panel
    $('[data-panel]').on('click', function () {
        $('.right_panel').remove()
        let panelHtml = `<div class="right_panel_overlay"></div>
                            <div class="right_panel"> 
                                <div class="modal_loader">
                                    <svg version="1.1" id="L7">
                                        <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z" transform="rotate(312.597 50 50)">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                        </path>
                                        <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z" transform="rotate(-265.194 50 50)">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite"></animateTransform>
                                        </path>
                                        <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5L82,35.7z" transform="rotate(312.597 50 50)">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                        </path>
                                    </svg> 
                                </div>
                            <div class="right_panel_close"><i class="fa fa-times"></i></div>
                            <div class="right_panel_print_btn"><i class="fa fa-print"></i></div>
                            <header class="right_panel_header">
                            <h2 class="right_panel_title">${$(this).data('title')}</h2>
                            <span class="right_panel_date">${$(this).data('date')}</span>
                            </header>
                            <div class="right_panel_content"></div>
                        </div>`
        $('body').append(panelHtml)
        $('body').addClass('fixed')
        let panel = $('.right_panel')
        let thisTitle = $(this).children('.item_title').text()
        let title = $(panel).children('.right_panel_title')
        let content = $(panel).children('.right_panel_content')
        $('.modal_loader').fadeIn(200)
        $(panel).addClass('open')
        let data = { id: $(this).data('id') }
        let url = $(this).data('url')
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            beforeSend: function () {
                // NProgress.start();
            },
            complete: function () {
                $('.modal_loader').fadeOut(200)
            },
            success: function (res) {
                $(title).text(thisTitle)
                $(content).html(res);
                $('.right_panel_close, .right_panel_overlay').on('click', function () {
                    $('.right_panel').removeClass('open')
                    $('.right_panel, .right_panel_overlay').remove()
                    $('body').removeClass('fixed')
                })
                
                loadFeedback()
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    })
    // функция повторной инициализации елементов формы обращения
    function loadFeedback(){
        $('.modal_loader').fadeIn(200)
        $('.tab_item').on('click', function(){
            if(!$(this).hasClass('active')){
                $('.tab_item').removeClass('active')
                $(this).addClass('active')
                let activeTab = $('.tab_item.active').data('tab')
                $(`.tab_content`).fadeOut()//.removeClass('active')
                $(`.tab_content[data-tab-content="${activeTab}"]`).fadeIn()//.addClass('active')
            }else{
                $('.tab_item').removeClass('active')
                $(`.tab_content`).fadeOut()//.removeClass('active')
            }
        })
        let filesArr = uploaderImg('#answer_file_input', false, false);
        $('.responsible_search').on('input', function(){
            let parrent = $(this).parent('.group')
            if($(this).val().length > 0){
                $(this).next().addClass('is_active') 
                $(parrent).addClass('input_loader')
            }else{
                $(this).next().removeClass('is_active') 
                $(this).removeClass('input_loader')
            }
            $.ajax({
                type: "GET",
                url: '../bitrix/templates/app/api/person.php',
                data: {query: $(this).val()},
                beforeSend: function () {
                    // $('.modal_loader').fadeIn(200)
                },
                complete: function () {
                    // $('.modal_loader').fadeOut(200)
                    // $('.responsible_search').removeClass('input_loader')
                },
                success: function (res) {
                    $('.responsible_search_list').html('')
                    if(res.success){
                        res.departament.forEach(departament =>{
                            $('.responsible_search_list').append(`<li data-id="${departament.id}" data-val="${departament.name}">${departament.name}<span>${departament.cheif}</span></li>`)
                        })
                        $('.responsible_search_list').slideDown()
                        $('.responsible_search_list li').on('click', function(){
                            $('.responsible_search').val($(this).data('val'))
                            $('.responsible_search').data('elid',$(this).data('id'))
                            $('.responsible_search').next().addClass('is_active')
                            $('.responsible_search_list').slideUp()
                            $(parrent).removeClass('input_loader')
                        })
                    }
                },
                error: function (err) {
                    mainToast(5000, "error", 'Ошибка загрузки!', err)
                }
            });
        })
        $('.responsible_add').on('click', function(){
            let input = $(this).parent().find('.responsible_search')
            if($('.timeline').find('li[data-event="add_responsible"]').length > 0){
                changeAplication('change_responsible', $(input).data('elid'))
            }else{
                changeAplication('add_responsible', $(input).data('elid'))
            }
        })
        $('.right_panel_content .group').each(function(){
            let label = $(this).find('label')
            let input = $(this).find('input')
            let textarea = $(this).find('textarea')
            if($(input).val() && $(input).val().length > 0 || $(textarea).val() && $(textarea).val().length > 0){
                $(label).addClass('is_active')
            }else{
                $(label).removeClass('is_active')
            }
        })
        $('.feed-detail-status-line').each(function(){
            let id = $(this).data('status-active')
            let li = $(this).find(`li[data-status-id="${id}"]`)
            let elLi = $(this).find('li')
            if($(li).nextAll().length > 0){
                $(li).nextAll().addClass('is_none')
            }
            $(elLi).on('click', function(){
                if($(this).data('status-id') != id){
                    $(this).nextAll().addClass('is_none')
                    $(this).removeClass('is_none')
                    $('.modal_loader').fadeIn(200)
                    changeAplication('change_status', $(this).data('status-id'))
                }
            })
        })
        $('.add_comment').on('click', function(){
            let comment = $(this).parent().find('.comment_field')
            if($(comment).val().length > 0){
                changeAplication('add_comment', $(comment).val())
            }
        })
        $('.add_answer').on('click', function(){
            let textarea = $(this).parent().find('textarea')
            answerApplication('add_answer', $(textarea).val(), filesArr)
        })
        $('.modal_loader').fadeOut(200)
        initPopup()
        $('.right_panel_print_btn').on('click', function(){
            let block = $(this).parent().find('.block_to_print')
            PrintDiv(block)
        })
        // timeline item action
        $('.timeline_item_action_btn').on('click', function(){
            $('.timeline_item_action').removeClass('active')
            $(this).next().addClass('active')
            
        })
        $('.timeline_item_action li').on('click', function(){
            timelineItemAction('delete_timeline', $(this).data('id'))
        })
        $(document).on("click", function(event) {
            if (!$(event.target).hasClass('outsideclick') && $(event.target).closest(".outsideclick").length === 0) {
                $(".outsideclick").removeClass('active')
            }else{
                
            }
        });
    }
    // функция обработки событий на item таймлайна
    function timelineItemAction(action, id){
        $.ajax({
            type: "POST",
            url: '../bitrix/templates/app/api/change_feed_app.php',
            data: {action, element: $('.feed-detail').data('elid'), id},
            // contentType: false,
            // processData: false,
            success: function (res) {
                if(res.success){
                    loadApplication($('.feed-detail').data('elid'))
                }
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    // функция подгрузки обращения при изменении
    function loadApplication(id){
        $.ajax({
            type: "GET",
            url: '../bitrix/templates/app/api/application_detail.php',
            data: { id: id },
            beforeSend: function () {
                $('.modal_loader').fadeIn()
            },
            complete: function () {
                $('.modal_loader').fadeOut()
            },
            success: function (res) {
                $('.right_panel_content').html(res)
                loadFeedback()
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    // функция отправки ответа
    function answerApplication(action, text, files){
        let data = new FormData()
        data.append('action', action)
        data.append('element', $('.feed-detail').data('elid'))
        data.append('text', text)
        for(var id in files){
            data.append('answer_files[]', files[id]);
        }
        $.ajax({
            type: "POST",
            url: '../bitrix/templates/app/api/change_feed_app.php',
            data: data,
            contentType: false,
            processData: false,
            success: function (res) {
                if(res.success){
                    console.log(res);
                    loadApplication($('.feed-detail').data('elid'))
                }
                // mainToast(5000, res.status, ``, res.result)
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    // функция смены данных
    function changeAplication(action, value){
        $.ajax({
            type: "POST",
            url: '../bitrix/templates/app/api/change_feed_app.php',
            data: {action, element: $('.feed-detail').data('elid'), value},
            success: function (res) {
                if(res.success){
                    console.log(res);
                    loadApplication($('.feed-detail').data('elid'))
                }
                // mainToast(5000, res.status, ``, res.result)
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    let filterParams = { 
        iblock: null,
        section: null, 
        date: null, 
        sort: 'desc', 
        type: '', 
        PAGEN_1: 1 
    }
    // отслеживаем изменения параметров фильтра
    let filterProxied = new Proxy(filterParams, {
    get: function(target, prop) {
        // console.log({
        // 	type: "get",
        // 	target,
        // 	prop
        // });
        return Reflect.get(target, prop);
    },
    set: function(target, prop, value) {
            // console.log({
            // 	type: "set",
            // 	target,
            // 	prop,
            // 	value
            // });
            setTimeout(()=>{
                GetFilter(target)
            },10)
            
            return Reflect.set(target, prop, value);
        }
    });
    
    // document filter
    $('#filter_document').each(function () {
        let iblock = $('.document_list').data('iblock') ? $('.document_list').data('iblock') : null
        let docName = $(this).find('input#filter_name')
        let sectionSelect = $(this).find('select#filter_section')
        let datePicker = $(this).find('input#filter_date')
        let sortButton = $(this).find('button#filter_sort');
        filterProxied.iblock = iblock
        // фильтр по названию
        $(docName).on('input', function () {
            filterProxied.name = $(this).val()
        })
        // филmтр по дате
        $(datePicker).on('input', function () {
            if ($(this).val().length >= 0) {
                filterProxied.date = null
            }
        })
        $(datePicker).datepicker({
            onSelect: function (formattedDate, date, inst) {
                if (date) {
                    filterProxied.date = formattedDate;
                }
            }
        }).data('datepicker');
        // фильтр по разделам
        $(sectionSelect).select2({
            //minimumResultsForSearch: -1
        })
        $(sectionSelect).on('change', function () {
            if ($(this).val() == 'all') {
                filterProxied.section = '#';
            } else {
                filterProxied.section = $(this).val();
            }
        });
        // сортировка
        $(sortButton).on('click', function () {
            let dataSort = $(this).attr('data-sort', function (index, attr) {
                return attr == 'desc' ? 'asc' : 'desc';
            });
            let sort = $(dataSort).attr('data-sort')
            if (sort == 'asc') {
                $(this).html('<i class="fa fa-sort-amount-asc"></i> По возрастанию')
            } else {
                $(this).html('<i class="fa fa-sort-amount-desc"></i> По убыванию')
            }
            filterProxied.sort = sort
        })
        // функция получения данных 

    })
    function GetFilter(param) {
        $.ajax({
            type: "GET",
            url: '/bitrix/templates/app/api/document.php',
            data: param,
            beforeSend: function () {
                NProgress.start();
            },
            complete: function () {
                NProgress.done();
            },
            success: function (res) {
                
                $('.tooltip-inner').remove()
                $('.document_list').html(res);
                $('.paginationjs-page').on('click', function () {
                    filterProxied.PAGEN_1 = $(this).attr('data-pagenum');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                });
                $('.act').on('click', function () {
                    filterProxied.PAGEN_1 = $(this).attr('data-pagenum');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                });

                $('[data-toggle="tooltip"]').tooltip({
                    animated: 'fade',
                    html: true
                })
                folderAnimation()
                downloadZIP()
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    // download zip 
    function downloadZIP(){
        $('.download_zip').on('click', function(){
            let parent  = $(this).parent()
            let arLi    = $(parent).children('li')
            let files   = []
            arLi.map(li => {
                if(!$(arLi[li]).hasClass('download_zip'))
                    files.push({filename: $(arLi[li]).find('.folder-item__details__name').text(), filepath: $(arLi[li]).find('a').attr('href')})
            });
            $.ajax({
                type: "POST",
                url: '/bitrix/templates/app/api/zip.php',
                data: {files: JSON.stringify(files)},
                beforeSend: function () {
                    NProgress.start();
                },
                complete: function () {
                    NProgress.done();
                },
                success: function (res) {
                    console.log(res)
                    window.open(`http://vladikavkaz-osetia.ru/download_zip.php?download=${res.download}&path=${res.path}&name=${res.name}`, '_blank');
                },
                error: function (err) {
                    mainToast(5000, "error", 'Ошибка загрузки!', err)
                }
            });
        })
    }
    downloadZIP()
    // tabs 
    function tabsInit() {
        let clickedTab = $(".tabs > .active");
        let tabWrapper = $(".tab__content");
        let activeTabs = tabWrapper.find(".active");
        let activeTabHeight = activeTabs.outerHeight();
        activeTabs.show();
        tabWrapper.height(activeTabHeight);
        $(".tabs > li").on("click", function () {
            $(".tabs > li").removeClass("active");
            $(this).addClass("active");
            clickedTab = $(".tabs .active");
            activeTabs.fadeOut(250, function () {
                $(".tab__content > li").removeClass("active");
                var clickedTabIndex = clickedTab.index();
                $(".tab__content > li").eq(clickedTabIndex).addClass("active");
                activeTabs = $(".tab__content > .active");
                activeTabHeight = activeTabs.outerHeight();
                tabWrapper.stop().delay(50).animate({
                    height: activeTabHeight
                }, 500, function () {

                    activeTabs.delay(50).fadeIn(250);
                });
            });
        });
    }
    tabsInit()
    //load more===============================================
    $(document).on('click', '.load_more', function () {
        var targetContainer = $('.ajax-list'),          //  Контейнер, в котором хранятся элементы
            url = $('.load_more').attr('data-url');    //  URL, из которого будем брать элементы
        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function (data) {
                    //  Удаляем старую навигацию
                    $('.load_more').remove();

                    var elements = $(data).find('.ajax-list-item'),  //  Ищем элементы
                        pagination = $(data).find('.load_more');//  Ищем навигацию
                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetContainer.append(pagination); //  добавляем навигацию следом
                }
            })
        }
    });
    //banner
    if (localStorage.getItem('banner') !== null) {
        $('.banner').hide()
    } else {
        $('.banner').fadeIn(300)
    }
    $('.banner .btn_close').on('click', function () {
        $('.banner').hide()
        localStorage.setItem('banner', 'hide')
    })
    if (localStorage.getItem('view') !== null) {
        $('.view_btn button').removeClass('active')
        $(`.view_btn button.${localStorage.getItem('view')}`).addClass('active')
        $('.tree').attr('data-view', localStorage.getItem('view'))
    }else{
        $('.view_btn button').removeClass('active')
        $(`.view_btn button.${$('.tree').attr('data-view')}`).addClass('active')
    }
    //qwdadqa
    $('.view_btn button').on('click', function () {
        $('.view_btn button').removeClass('active')
        $(this).toggleClass('active')
        if ($(this).attr('data-view') == 'utter') {
            localStorage.setItem('view', 'utter')
            $('.tree').attr('data-view', 'utter')
        } else {
            localStorage.removeItem('view')
            $('.tree').attr('data-view', 'small')
        }
    })
    // animated
    function animateCSS(element, animationName, callback) {
        const node = element
        node.classList.add('animated', animationName)

        function handleAnimationEnd() {
            node.classList.remove('animated', animationName)
            node.removeEventListener('animationend', handleAnimationEnd)

            if (typeof callback === 'function') callback()
        }

        node.addEventListener('animationend', handleAnimationEnd)
    }
    // toltip
    $('.bs-tooltip-bottom').remove()
    $('[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        html: true
    })
    // popover
    $('.popover').remove()
    $('[data-toggle="popover"]').popover({
        html: true,
        placement: 'bottom',
        container: 'body'
    })
    // structure tree
    $('.tree_item').popover({
        html: true,
        container: 'body'
    })
    $('.tree ul li:first-child ul li').each(function(){
        let li = $(this)
        let ul = $(li).children('ul')
        $(ul).hide().addClass('hide')
    })
    $('.tree_item').each(function () {
        let parent = $(this).parent('li')
        let ul = $(parent).children('ul')
        $(this).find('.select_btn').remove()
        if ($(ul).length && !$(ul).hasClass('hide')) {
            $(this).append(`<button class="select_btn">Свернуть <i class="fa fa-chevron-up"></i></button>`)
        } else if($(ul).length && $(ul).hasClass('hide')) {
            $(this).append(`<button class="select_btn active">Развернуть <i class="fa fa-chevron-down"></i></button>`)
        }else{
            $(this).find('.select_btn').remove()
        }
    })
    $('.select_btn').on('click', function () {
        let li = $(this).parent('.tree_item').parent('li')
        let ul = $(li).children('ul')
        // $(this).toggleClass('active')
        if (ul.length > 0) {
            $(this).toggleClass('active')
        }
        if ($(this).hasClass('active')) {
            $(this).html('Развернуть <i class="fa fa-chevron-down"></i>')
            $(ul).hide()
        } else {
            $(this).html('Свернуть <i class="fa fa-chevron-up"></i>')
            $(ul).show()
        }
    })

    $('.tree_small li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree_small li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-square').removeClass('fa-minus-square');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-square').removeClass('fa-plus-square');
        }
        e.stopPropagation();
    });
    $('#month_sel').select2({
        language: "ru"
    });
    $('#year_sel').select2({
        language: "ru"
    });
    $('#news_cat').select2({
        language: "ru"
    });
    //  модальное окно формы обращений
    $("#modal_app_form").iziModal({
        headerColor: "#62D4BD",
        width: 840,
        top: 50,
        bottom: 50,
        radius: 5,
        onFullscreen: function () {
            $('.modal_loader').fadeIn("slow");
        },
        onResize: function () {
            $('.modal_loader').fadeOut("slow");
        },
        onOpening: function () {
            getAppForm()
            $('.modal_loader').fadeIn("slow");
            $('.submit_disabled').show()
            $('.btn_submit').hide()
        },
        onOpened: function () {
            $('.modal_loader').fadeOut("slow");
        },
        onClosing: function () { },
        onClosed: function () { },
        afterRender: function () { }
    });

    function getAppForm(){
        $.ajax({
            type: "GET",
            url: '/bitrix/templates/app/api/app_form.php',
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (res) {
                $('.modal_content').html(res)
                initAppFormElement()
                getNewToken()
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    function initAppFormElement(){
        $('#app_form_departament').select2({
            language: "ru"
        });
        $('#need_person').on('change', function () {
            if ($(this).is(':checked')) {
                $('#person').select2({
                    language: "ru"
                });
            } else {
                $('#person').select2('destroy');
            }
        })
        // Вывод ошибок при валидации всей формы
        $("form.app_form").validate({
            errorElement: "span"
        });
        let activeTab = []
        // Маска для поля телефон
        $('#app_form_persondata_phone').mask('+7 (000) 000-00-00', {
            onChange: function (cep) {
                $('#app_form_persondata_phone').next('.error_message').remove()
            },
            onInvalid: function (val, e, f, invalid, options) {
                let error = invalid[0];
                $(e.target).next('.error_message').remove()
                $(e.target).after(`<span class="error_message">${error.p - 2} не валидный сивол!</span>`)
            }
        })
        
        // // Поле Е-почты
        // $('#app_form_persondata_email').on('input', function () {
        //     let valid = isEmail($(this).val())
        //     if (valid) {
        //         $(this).next('.error_message').remove()
        //     } else {
        //         $(this).next('.error_message').remove()
        //         $(this).after(`<span class="error_message">Не валидная е-почта!</span>`)
        //     }
        // });
        // Поле пользовательское соглашение
        $('#app_form_consent').each(function () {
            let form_tab = $(this).closest('.form_tab')
            let tabNumber = $(form_tab).data('event-num')
            let event = $(form_tab).find('.form_tab_event')
            if ($(this).is(':checked')) {
                $(form_tab).addClass('is_valid')
                $(event).html('<i class="fa fa-check"></i>')
                activeTab.push(tabNumber)
            } else {
                $(form_tab).removeClass('is_valid')
                $(event).html(tabNumber)
            }
        })
        $('.btn_submit').hide()
        // Проверка выпадающего списка
        $('select#app_form_departament').on('select2:select', function (e) {
            if(e.target.value == '#'){
                $(e.target).addClass('err')
                $('.app_form .select2-container .select2-selection--single').css({'border-color' : '#e25460'})
            }else{
                $(e.target).removeClass('err')
                $('.app_form .select2-container .select2-selection--single').css({'border-color' : '#62d4bd'})
            }
        });
        // Проверка по клику всей формы на валидность
        $('.btn_submit_disabled').on('click', function(){
            let selectVal = $('select#app_form_departament').val() 
            let select = $('.app_form .select2-selection--single')
            let inputs = [...$('input[required]')]
            let textareas = [...$('textarea[required]')]
            if(selectVal == '#'){
                $(select).addClass('err')
                $('.app_form .select2-container.select2-selection--single').css({'border-color' : '#e25460'})
            }else{
                $(select).removeClass('err')
                $('.app_form .select2-container.select2-selection--single').css({'border-color' : '#62d4bd'})
            }

            inputs.forEach(input => {
                if($(input).val() == '' || $(input).val().length == 0 && !$(input).is(':checked')){
                    $(input).addClass('err')
                }else{
                    $(input).removeClass('err')
                }
            });
            textareas.forEach(textarea => {
                if($(textarea).val().length == 0){
                    $(textarea).addClass('err')
                }else{
                    $(textarea).removeClass('err')
                }
            });
            
            let errElement = $('.err')

            if(errElement.length > 0){
                let firstElPosition = $(errElement[0]).offset().top - $('.app_form').offset().top - $('.app_form').scrollTop() - 20 
                $(this).parent().find('span.error').remove()
                $(this).parent().append('<span class="error" style="text-align: center;">Возможно вы пропустили обязательные поля, перепроверьте все поля</span>')
                $('.iziModal-wrap').animate({
                    scrollTop: firstElPosition
                }, 300);
            }else{
                $('.submit_disabled').hide()
                $('.btn_submit').show()
            }
            
        })
        // Проверка на заполнение всех полей (валидация секций формы)
        $('.form_tab').on('change', function () {
            let that = this
            let textarea = $(this).find('textarea')
            let input = $(this).find('input[required]')
            let departament = $(this).find('select#app_form_departament')
            let person = $(this).find('select#person')
            let juristic = $(this).find('input#app_form_persondata_juristic')
            let need_person = $(this).find('input#need_person')
            let tabNumber = $(this).data('event-num')
            let consent = $(this).find('#app_form_consent')
            let button = $('.btn_submit')
            let inputStatus = []
            let textareaStatus = []
            // проверяем заполнено ли поле если да то закидываем в массив ok если нет то но
            $(input).each(function () {
                if (this.value !== '') {
                    $(this).addClass('valid')
                    inputStatus.push({input: $(this).data('input'), status: true});
                }else {
                    $(this).removeClass('valid')
                    inputStatus.push({input: $(this).data('input'), status: false});
                }


                let inputValidCount = inputStatus.filter(inp=> inp.status === true).length // если юр лицо значение 6 если нет то 5 или меньше
                // проверка от физ \ юр лица
                if ($(juristic).is(':checked')) {
                    if (inputValidCount === 6) {
                        formTab(that,true)
                    } else {
                        formTab(that)
                    }
                } else {
                    if (inputValidCount === 5) {
                        formTab(that,true)
                    } else {
                        formTab(that)
                    }
                }
            })
            $(textarea).each(function () {
                if (this.value.length == 0) {
                    textareaStatus.push({textarea: $(this).data('textarea'), status: false});
                }
                else {
                    textareaStatus.push({textarea: $(this).data('textarea'), status: true});
                }
                let textareaValidCount = textareaStatus.filter(textarea=> textarea.status === true).length
                if (textareaValidCount === 2) {
                    formTab(that,true)
                }else{
                    formTab(that)
                }
            })
            $(departament).each(function () {
                if (this.value != '#' && this.value != '') {
                    formTab(that,true)
                } else {
                    formTab(that)
                }
            })
            if ($(need_person).is(':checked')) {
                if ($(person).val() != '#' && $(person).val() != '') {
                    formTab(that,true)
                } else {
                    formTab(that)
                }
            }
            $(consent).each(function () {
                if ($(this).is(':checked')) {
                    formTab(that,true)
                } else {
                    formTab(that)
                }
            })
            if ($(this).hasClass('is_valid')) {
                if (!activeTab.includes(tabNumber)) {
                    activeTab.push(tabNumber);
                }
            } else {
                let index = activeTab.indexOf(tabNumber);
                if (index > -1) {
                    activeTab.splice(index, 1);
                }
            }
            if (activeTab.length >= 4) {
                $('.form_tab').addClass('is_valid')
                $('.form_submit').addClass('is_valid')
                $('.submit_disabled').hide()
                $(button).show()
                $(button).prop("disabled", false)
            } else {
                $('.form_submit').removeClass('is_valid')
                $('.submit_disabled').show()
                $(button).hide()
                $(button).prop("disabled", true)
            }
        })
        // Подсказка поля адрес
        $('#app_form_persondata_address').suggestions({
            token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
            type: "ADDRESS",
            onSelect: function(suggestion) {
                // console.log(suggestion.data)
            }
        });
        // Подсказка поля е-почта
        $('#app_form_persondata_email').suggestions({
            token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
            type: "EMAIL",
            onSelect: function(res) {
                $('#app_form_persondata_email').next('.error_message').remove()
            }
        });
        // Изменение фомы под ЮР-лицо
        $('input#app_form_persondata_juristic').on('change', function () {
            let firstname = $('input#app_form_persondata_firstname')
            let name = $('input#app_form_persondata_name')
            let lastname = $('input#app_form_persondata_lastname')
            let email = $('input#app_form_persondata_email')
            let address = $('input#app_form_persondata_address')
            let phone = $('input#app_form_persondata_phone') 
            if ($(this).is(':checked')) {
                $('#orgname').fadeIn()
                $('#orgname').find('input').attr('required', true)
                $(firstname).parent().children('label').text('Фамилия руководителя*')
                $(name).parent().children('label').text('Имя руководителя*')
                $(lastname).parent().children('label').text('Отчество руководителя')
                $(email).parent().children('label').text('Е-почта организации*')
                $(phone).parent().children('label').text('Контактный телефон*')
                $(address).parent().children('label').text('Адрес организации*')
                $('#app_form_persondata_orgname').suggestions({
                    token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
                    type: "PARTY",
                    onSelect: function(suggestion) {
                        if(suggestion.data){
                            let manager = ''
                            switch (suggestion.data.type) {
                                case 'INDIVIDUAL':
                                    manager = suggestion.data.name.full.split(' ')
                                    break;
                                default:
                                    manager = suggestion.data.management.name.split(' ')
                                    break;
                            }
                            $('#app_form_persondata_orgname').parent('.group').children('label').addClass('is_active')
                            $('#app_form_persondata_firstname').val(manager[0]).parent('.group').children('label').addClass('is_active')
                            $('#app_form_persondata_name').val(manager[1]).parent('.group').children('label').addClass('is_active')
                            $('#app_form_persondata_lastname').val(manager[2]).parent('.group').children('label').addClass('is_active')
                        }
                        $('#app_form_persondata_address').val(suggestion.data.address.value).parent('.group').children('label').addClass('is_active')
                    }
                });
            } else {
                $(firstname).parent().children('label').text('Фамилия*')
                $(name).parent().children('label').text('Имя*')
                $(lastname).parent().children('label').text('Отчество')
                $(email).parent().children('label').text('Е-почта*')
                $(phone).parent().children('label').text('Контактный телефон*')
                $(address).parent().children('label').text('Адрес*')
                $('#orgname').fadeOut()
                $('#orgname').find('input').attr('required', false)
            }
        })
        // Подчеркивание заполненых полей
        $('.group').each(function () {
            let textarea    = $(this).find('.app_form_textarea')
            let input       = $(this).find('input')
            let label       = $(this).find('label')
            $(textarea).on('input', function () {
                if ($(textarea).val().length > 0) {
                    $(label).addClass('is_active')
                } else {
                    $(label).removeClass('is_active')
                }
            })
            $(input).on('input', function () {
                if ($(input).val().length > 0) {
                    $(label).addClass('is_active')
                } else {
                    $(label).removeClass('is_active')
                }
            })
        })
        // Подсчет количества символов в поле
        $('.group').each(function () {
            let textarea = $(this).find('textarea')
            $(textarea).on('input', function () {
                let text = $(this).data("text")
                let count = $(this).data('count')
                let remain = text + ' осталось ' + (count - $(this).val().length) + ' из ' + count
                if ((count - $(this).val().length) < 0) {
                    $(this).next("label")
                        .css({ 'color': 'red' })
                        .text('Лимит символов превышен!')
                } else if ($(this).val().length > 0) {
                    $(this).next("label")
                        .attr('style', '')
                        .text(remain)
                } else {
                    $(this).next("label")
                        .attr('style', '')
                        .text(text)
                }
            })
        })
        // отправка обращения
        $('.app_form').on('submit', function (event) {
            event.preventDefault();
            $('.btn_submit').hide()
            $('#clock').show()
            let method = $(this).attr('method')
            let action = $(this).attr('action')
            let formData = new FormData(this)
            for (var id in filesArr) {
                formData.append('files[]', filesArr[id]);
            }
            $.ajax({
                url: action,
                type: method,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.modal_loader').fadeIn("slow");
                },
                complete: function () {
                    $('.modal_loader').fadeOut("slow");
                },
                success: function (res) {
                    let appMessage = `<div class="app_form_message">
                                        <span class="app_form_message_close">
                                            <i class="fa fa-times"></i>
                                        </span>
                                        <h3 class="app_form_message_title">${res.title}</h3>
                                        <p>${res.desc}</p>
                                    </div>`
                    $('.modal_content').html(appMessage)
                },
                error: function (err) {
                    mainToast(time = 5000, param = 'error', err, text = 'Обращение не отправлено!')
                }
            })
        });
        let filesArr = uploaderImg('#js-photo-upload', false, false);
    }
    // Функция проверки Е-почты
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    // функция добавления активности разделам формы при заполнении
    function formTab(tab,valid = false){
        let tabNumber = $(tab).data('event-num')
        let event = $(tab).find('span.form_tab_event')
        if(valid){
            $(tab).addClass('is_valid')
            $(event).html('<i class="fa fa-check"></i>')
        }else{
            $(tab).removeClass('is_valid')
            $(event).html(tabNumber)
        }
    }
    // функция получения токена для рекаптчи
    function getNewToken(){
        grecaptcha.ready(function () {
            grecaptcha.execute('6Lf3hssZAAAAAK2SOCPR9V8zAbClunlgAlNjYLKT', { action: "homepage" })
            .then(async token => {
                document.getElementById('token').value = await token
            });
        });
    }
    getNewToken()
    
    // Форма обращений \


    // home document list
    function showMore(list) {
        let container = $(list)
        let button = $(container).find('.show_more')
        $(container).each(function () {
            let url = $(this).data('url')
            let amount = $(this).data('amount')
            //let activeBoxesHide = $(this).find('.item:gt(' + (amount - 1) + ')').hide()
            let activeBoxesHide = $(this).find('.item:gt(' + (amount - 1) + ')').fadeOut()
            $(button).on('click', function () {
                $(this).toggleClass('active')
                if ($(this).hasClass('active')) {
                    $(this).html('Скрыть <i class="fa fa-chevron-up"></i>')
                    activeBoxesHide.fadeIn(300)
                    $(container).append(`<a class="show_all" href="${url}">Показать все <i class="fa fa-angle-right"></i></a>`)
                } else {
                    $(this).html('Раскрыть <i class="fa fa-chevron-down"></i>')
                    $(container).find('a.show_all').remove()
                    activeBoxesHide.fadeOut(300);
                }
            })
        })
    }
    showMore('.doc_list')
    showMore('.useful_link_list')
    const list = document.querySelectorAll('.list');
    $(list).find(".parent-selected").attr("href", "");
    function accordion(e) {
        e.stopPropagation();
        if (this.classList.contains('active')) {
            this.classList.remove('active');
        }
        else if (this.parentElement.parentElement.classList.contains('active')) {
            this.classList.add('active');
        }
        else {
            for (i = 0; i < list.length; i++) {
                list[i].classList.remove('active');
            }
            this.classList.add('active');
        }
    }
    for (i = 0; i < list.length; i++) {
        list[i].addEventListener('click', accordion);
    }
    // search button
    $('.search').on('click', function () {
        $('.top_content').fadeIn(200)
        $('.search_form').slideDown(300)
    })
    $('.search_close').on('click', function () {
        $('.search_form').slideUp(300)
        $('.top_content').fadeOut(200)
    })
    // search request
    $('.search_input').on('input', function () {
        if ($(this).val().length >= 3) {
            changeButton('search')
        } else {
            changeButton('')
            $('.search_result').fadeOut("slow")
        }
    })
    $('#search_filter_date').datepicker({
        onSelect: function (formattedDate, date, inst) {
            if (date) {
                let resDate = formattedDate.split(' - ')
                $('input.date_from').val(resDate[0])
                $('input.date_to').val(resDate[1])
            }
        }
    })
    .data('datepicker')
    if($('#search_filter_date').length > 0){
        if($('input.date_from').val().length > 0 || $('input.date_to').val().length > 0){
            $('#search_filter_date').val(`${$('input.date_from').val()} - ${$('input.date_to').val()}`)
        }
    }
    if(localStorage.getItem('search_param')){
        $('#search_params').addClass('active')
    }else{
        $('#search_params').removeClass('active')
    }
    $('a.search-page-params').on('click', function(){
        $(this).toggleClass('active')
        if($(this).hasClass('active')){
            localStorage.setItem('search_param', 'show')
            $('#search_params').addClass('active')
        }else{
            localStorage.removeItem('search_param')
            $('#search_params').removeClass('active')
        }
    })
    function changeButton(param = 'search') {
        if (param == 'search') {
            $('.search_btn').addClass('active')
            $('.search_btn').removeClass('remove')
            $('.search_btn').addClass('searched')
            $('.search_btn').html('<i class="fa fa-search"></i> Искать')
        } else if (param == 'remove') {
            $('.search_btn').addClass('active')
            $('.search_btn').removeClass('searched')
            $('.search_btn').addClass('remove')
            $('.search_btn').html('<i class="fa fa-times"></i> Очитстить')
        } else {
            $('.search_btn').removeClass('active')
        }
    }
    // number animation
    const numberBlock = document.getElementById("numbers");
    var scores = [];
    let numberElement = $('.num_item');
    for (let i = 0; i < numberElement.length; i++) {
        scores.push({ score: parseInt($(numberElement[i]).attr('data-start')), end: parseInt($(numberElement[i]).attr('data-end')) })
    }
    if (numberBlock !== null) {
        window.addEventListener('scroll', function () {
            const numberBlockPos = numberBlock.offsetTop,
                winHeight = window.innerHeight;
            let winScrollTop = window.scrollY,
                scrollToElem = winScrollTop + winHeight
            if ((scrollToElem + 30 > numberBlockPos) && $('.num_item').children('div').text() == '000') {
                for (let i = 0; i < scores.length; i++) {
                    TweenMax.to(scores[i], 4, { score: scores[i].end, onUpdate: updateHandler, onUpdateParams: [i] });
                }
            }

        });
    }
    function updateHandler(index) {
        let numberBlock = document.querySelector('.num_item[data-target="' + index + '"] div');
        numberBlock.innerHTML = scores[index].score.toFixed(0);
    }
    // toast
    function mainToast(time = 5000, param = '', title = '', text = '') {
        /*
        param: info, success, warning, error
        */
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": time,
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[param](title, text)
    }
    // fileupload 
    function uploaderImg(addInput, reset = false, edit = false) {
        let addButton = $(addInput).parent('.uploader_files').find('.uploader_files_item')
        let imgList = $(addInput).parent('.uploader_files').find('.uploader_files_list')
        $(addButton).on('click', function () {
            $(addInput).trigger('click');
        })
        var maxFileSize = 5 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
        var queue = {};
        var imagesList = $(imgList);
        var itemPreviewTemplate = imagesList.find('.item').detach();
        var filelist = imagesList.children().length;
        // Вычисление лимита
        function limitUpload() {
            if (filelist > 0 || edit) {
                return 5 - filelist;
            } else if (filelist == 0 || !edit) {
                return 5 - imagesList.children().length;
            }
        }
        // Отображение лимита
        function limitDisplay() {
            let sTxt;
            switch (limitUpload()) {
                case 5:
                    sTxt = '<span class="text">Прикрепить ' + limitUpload() + ' файлов</span>';
                    break;
                case 0:
                    sTxt = 'Достигнут лимит';
                    break;
                default:
                    sTxt = 'можно добавить ещё ' + limitUpload();
            }
            $(addButton).html(sTxt);
        }
        function limitSize() {
            $(addInput).on('change', function () {
                var total = 0;
                for (var i = 0; i < this.files.length; i++) {
                    total = total + this.files[i].size;
                }
                return total;
            });
        }
        limitSize();
        $(addInput).on('change', function () {
            var files = this.files;
            var fileTypeArr = [
                'jpeg',
                'jpg',
                'png',
                'pdf',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'zip',
                'rar',
            ];
            // Перебор файлов до лимита
            for (var i = 0; i < limitUpload(); i++) {
                let file = files[i];
                let fileType = ''
                if (file !== undefined) {
                    fileType = file.name.split('.').pop()
                    if ($.inArray(fileType, fileTypeArr) < 0) {
                        $(".errormassege").text('')
                        $(".errormassege").append('Файлы должны быть в формате jpg, jpeg, png, zip, doc, docx, xls, xlsx, pdf');
                        continue;
                    }
                    if (file.size > maxFileSize) {
                        $(".errormassege").append("Размер файла не должен превышать 2 Мб")
                        continue;
                    }
                    $(".errormassege").html('');
                    preview(file, fileType);
                }
            }
            this.value = '';
        });

        function preview(file, fileType) {
            var reader = new FileReader();
            reader.addEventListener('load', function (event) {
                if (fileType == 'jpeg' || fileType == 'jpg' || fileType == 'png') {
                    var img = document.createElement('img');
                    var itemPreview = itemPreviewTemplate.clone();
                    itemPreview.find('.img-wrap img').attr('src', event.target.result);
                    itemPreview.data('id', file.name);
                    imagesList.append(itemPreview);
                } else {
                    var itemPreview = itemPreviewTemplate.clone();
                    $(itemPreview).find('.img-wrap').remove();
                    let icon = 'fa-file'
                    switch (fileType) {
                        case 'xls':
                            icon = 'fa-file-excel-o'
                            break;
                        case 'xlsx':
                            icon = 'fa-file-excel-o'
                            break;
                        case 'rar':
                            icon = 'fa-file-archive-o'
                            break;
                        case 'zip':
                            icon = 'fa-file-archive-o'
                            break;
                        case 'docx':
                            icon = 'fa-file-word-o'
                            break;
                        case 'doc':
                            icon = 'fa-file-word-o'
                            break;
                        case 'pdf':
                            icon = 'fa-file-pdf-o'
                            break;
                        default:
                            icon = 'fa-file'
                            break;
                    }
                    itemPreview.find('.icon-wrap i').addClass(icon);
                    itemPreview.data('id', file.name);
                    imagesList.append(itemPreview);
                }
                // Обработчик удаления
                itemPreview.on('click', function () {
                    delete queue[file.name];
                    $(this).remove();
                    limitDisplay();
                });
                queue[file.name] = file;
                // Отображение лимита при добавлении
                limitDisplay();
            });
            reader.readAsDataURL(file);
        }
        // Очистить все файлы
        function resetFiles() {
            $(addInput)[0].value = "";
            limitDisplay();
        }
        if (reset) {
            resetFiles();
        }
        // Отображение лимита при запуске
        limitDisplay();
        return queue
    }
    // folder animation
    function folderAnimation(){
        $(".js_toggle-folder").on('click', function () {
            let top = 0
            let icon = $(this).find('.fa-folder')
            let iconOpen = $(this).find('.fa-folder-open')
            
            $(".js_toggle-folder").not(this).each(function () {
                $(this).parent().removeClass("active");
                $(this).removeClass("active");
                if($(this).find('.fa-folder').length > 0){
                    tl.to($(this).find('.fa-folder'), { opacity: 1, duration: 0.01 })
                    tl.to($(this).find('.fa-folder-open'), { opacity: 0, duration: 0.01 })  
                } 
                top = $(this).innerHeight()
            });
            $(this).parent().toggleClass("active");
            $(this).toggleClass("active");
            if ($(this).hasClass('active')) {
                $('.folder-content').slideUp(200)
                $('.folder.active').children('.folder-content').slideDown(200)
                    tl.to($(icon), { opacity: 0, duration: 0.01 })
                    tl.to($(iconOpen), { opacity: 1, duration: 0.01 })
                    tl.to($('.folder.active').children('.folder-content').children('.folder-item'), { y: 0, opacity: 1, stagger: 0.1, duration: .2, })
                    .then(function (res) {
                        let offsetFromScreenTop = $('.folder.active').offset().top - $(window).scrollTop();
                        if(offsetFromScreenTop >= 200 && Math.sign(offsetFromScreenTop) != -1){
                            $('html, body').animate({ scrollTop: parseInt($('.folder.active').offset().top) - 50 }, 300);
                        }else if(Math.sign(offsetFromScreenTop) == -1){
                            $('html, body').animate({ scrollTop: parseInt($('.folder.active').offset().top) - 50 }, 300);
                        }
                    })
            } else {
                tl.to($('.folder.active').children('.folder-content').children('.folder-item'), { y: -20, opacity: 0, stagger: 0.1, duration: 0.02, })
                    .then(function (res) {
                        $('.folder-content').slideUp(200)
                        tl.to($(icon), { opacity: 1, duration: 0.01 })
                        tl.to($(iconOpen), { opacity: 0, duration: 0.01 })
                        $('.folder.active').children('.folder-content').slideUp(200)
                    })
            }
        });
    }
    folderAnimation()
    // accordeon
    let maxHeight = Math.max($('.content').outerHeight(), $('#sidebar').outerHeight())
    $('#sidebar').height(maxHeight)
    $(".left_menu li .sub_open").on('click',function(e) {
        e.stopPropagation()
        let link = $(this);
        let closest_ul = link.closest("ul");
        let parallel_active_links = closest_ul.find(".active")
        let closest_li = link.closest("li");
        let link_status = closest_li.hasClass("active");
        let count = 0;

        closest_ul.find("ul").slideUp(function() {
                if (++count == closest_ul.find("ul").length)
                        parallel_active_links.removeClass("active");
                        $('#sidebar').height(maxHeight)
        });

        if (!link_status) {
                closest_li.children("ul").slideDown();
                closest_li.addClass("active");
                $('#sidebar').height('100%')
        }
})
    $('.root-item').on('click', function () {
        $('.root-item').removeClass('active')
        $(this).addClass('active')
    })
    ymaps.ready(init);
    function getCoords(street) {
        return new Promise((resolve, reject) => {
            ymaps.geocode(street).then(function (res) {
                resolve(res.geoObjects.get(0).geometry.getCoordinates())
            })
        })
    }
    async function init() {
        let street = $('.interception-data').data("interception");
        let streetOt = $('.interception-data').data("ot-interception");
        let streetDo = $('.interception-data').data("do-interception");
        let multiRoute
        let st
        let Ot
        let Do
        // Ищем координаты указанного адреса

        await getCoords('г.Владикаквказ ' + st).then(function (res) {
            st = res
        });
        await getCoords('г.Владикаквказ пересечение ' + street + ' ' + streetOt).then(function (res) {
            Ot = res
        });
        await getCoords('г.Владикаквказ пересечение ' + street + ' ' + streetDo).then(function (res) {
            Do = res
        });
        multiRoute = new ymaps.multiRouter.MultiRoute({
            // Точки маршрута. Точки могут быть заданы как координатами, так и адресом. 
            referencePoints: [
                'г.Владикаквказ пересечение ' + street + ' ' + streetOt,
                'г.Владикаквказ пересечение ' + street + ' ' + streetDo
            ]
        }, {
            // Автоматически устанавливать границы карты так,
            // чтобы маршрут был виден целиком.
            wayPointStartIconColor: "#FFFFFF",
            wayPointStartIconFillColor: "#ff0000",
            routeStrokeColor: "000088",
            routeActiveStrokeColor: "ff0000",
            pinIconFillColor: "ff0000",
            routeStrokeWidth: 3,
            // Внешний вид путевых точек.
            wayPointStartIconColor: "#FFFFFF",
            wayPointStartIconFillColor: "#ff0000",
            // Внешний вид линии активного маршрута.
            routeActiveStrokeWidth: 8,
            routeActiveStrokeStyle: 'solid',
            routeActiveStrokeColor: "#ff0000",
            // Внешний вид линий альтернативных маршрутов.
            //routeStrokeStyle: 'dot',
            routeStrokeWidth: 3,
            boundsAutoApply: false,
            // zoomMargin: 20
        });
        var myMap = new ymaps.Map("map", {
            center: Ot,//[43.024270378846325, 44.67674405029294],    //Создаём карту с центром в городе "Ростов-на-Дону"
            zoom: 18,

            controls: [] // 'searchControl','zoomControl',  'fullscreenControl'
        }, {
            searchControlProvider: 'yandex#search',
            minZoom: 14,
            maxZoom: 17
        });

        myMap.geoObjects.add(multiRoute);
        //{hasBalloon:false}
        myMap.behaviors.disable('click')
    }

    $('#map').height(Math.max($('.news-map').height()) + 15)


    function dmdChart(canvas, colors, counters, messages) {
        // And for a doughnut chart
        var ctx = canvas;
        data = {
          datasets: [{
            data: counters,
            backgroundColor: colors,
            borderWidth: 0,
            borderColor: "#333",
          }],
          labels: messages
        };
        var chart = new Chart(ctx, {
          type: 'pie',
          data: data,
          options: {
            responsive: true,
            legend: false,
            legendCallback: function (chart) {
              var legendHtml = [];
              legendHtml.push('<ul>');
              var item = chart.data.datasets[0];
              for (var i = 0; i < item.data.length; i++) {
                legendHtml.push('<li>');
                legendHtml.push('<span class="chart-legend" style="background-color:' + item.backgroundColor[i] + '"></span>');
                legendHtml.push('<span class="chart-legend-label-text">' + item.data[i] + ' ' + chart.data.labels[i] + '</span>');
                legendHtml.push('</li>');
              }
              legendHtml.push('</ul>');
              return legendHtml.join("");
            },
            tooltips: {
              enabled: true,
              mode: 'label',
              callbacks: {
                label: function (tooltipItem, data) {
                  var indice = tooltipItem.index;
                  return data.datasets[0].data[indice] + " " + data.labels[indice];
                }
              }
            },
          }
        });
        return chart.generateLegend();
      }
    
      $('.vote-item-circle').each(function () {
        var datas = $(this).find('.charts').children('#charts_data');
        var legend = $(this).find('.legend')
        var colors = [];
        var counters = [];
        var messages = [];
        var canvas = $(this).find('#charts_canvas');
        for (let i = 0; i < datas.length; i++) { // выведет 0, затем 1, затем 2
          colors.push(datas[i].dataset.color);
          counters.push(datas[i].dataset.counter);
          messages.push(datas[i].dataset.message);
        }
        var chart = dmdChart(canvas, colors, counters, messages);
        $(legend).html(chart)
      });

// scrol to top==========================================================================
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
        $('#toTop').fadeIn();
        } else {
        $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({ scrollTop: 0 }, 800);
    });
}