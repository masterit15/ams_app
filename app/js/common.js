jQuery(function ($) {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/bitrix/templates/app/js/sw.js')
            .then((reg) => {
            // регистрация сработала
                //console.log('Registration succeeded. Scope is ' + reg.scope);
            }).catch((error) => {
                console.log(error)
            });
    }
    $(document).pjax('a, #demo-list li a', '#pjax-container', { fragment: '#pjax-container', "timeout": 5000 });
    $('#pjax-container').on('pjax:success', function () {
        return false;
    });
    $(document).on('pjax:start', function () {
        NProgress.start();
    });
    $(document).on('pjax:end', function () {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
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
    // download zip 
    $('.download_zip').on('click', function(){
        let parent  = $(this).parent()
        let arLi    = $(parent).children('li')
        let files   = []
        arLi.map(li => {
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
                // location.href = `download_zip.php?${res.download}&${res.path}&${res.name}`
                window.open(`http://vladikavkaz-osetia.ru/download_zip.php?download=${res.download}&path=${res.path}&name=${res.name}`, '_blank');
                
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    })
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
        API.bind("open:finish", function () {
            // setTimeout(function () {
            //     $icon.addClass("active");
            // }, 0);
            // $icon.on("click", function () {
            //     API.close();
            // });
        });
        API.bind("close:finish", function () {
            // setTimeout(function () {
            //     $icon.removeClass("active");
            // }, 0);
            // $icon.on("click", function () {
            //     API.open();
            // });
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
        let panelHtml = `<div class="right_panel">
                            <div class="modal_loader">
                                <svg version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                    y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                    <path fill="#fff"
                                        d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z"
                                        transform="rotate(312.597 50 50)">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50"
                                            to="360 50 50" repeatCount="indefinite"></animateTransform>
                                    </path>
                                    <path fill="#fff"
                                        d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z"
                                        transform="rotate(-265.194 50 50)">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50"
                                            to="-360 50 50" repeatCount="indefinite"></animateTransform>
                                    </path>
                                    <path fill="#fff"
                                        d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5L82,35.7z"
                                        transform="rotate(312.597 50 50)">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50"
                                            to="360 50 50" repeatCount="indefinite"></animateTransform>
                                    </path>
                                </svg>
                            </div>
                            <div class="right_panel_close"><i class="fa fa-times"></i></div>
                            <h2 class="right_panel_title"></h2>
                            <div class="right_panel_content"></div>
                        </div>`
        $('body').append(panelHtml)
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
                NProgress.start();
            },
            complete: function () {
                NProgress.done();
                $('.modal_loader').fadeOut(200)
            },
            success: function (res) {
                $(title).text(thisTitle)
                $(content).html(res);
                // $(content).append(res);
                $('.right_panel_close').on('click', function () {
                    $('.right_panel').removeClass('open')
                    $('.right_panel').remove()
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
                $(this).nextAll().addClass('is_none')
                $(this).removeClass('is_none')
                $('.modal_loader').fadeIn(200)
                changeStatus($(this).data('elid'), $(this).data('status-id'))
            })
        })
        $('.modal_loader').fadeOut(200)
    }
    // функция подгрузки обращения при изменении
    function loadApplication(id){
        $.ajax({
            type: "GET",
            url: '../bitrix/templates/app/api/application_detail.php',
            data: { id: id },
            beforeSend: function () {
                NProgress.start();
            },
            complete: function () {
                NProgress.done();
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
    // функция смены статуса
    function changeStatus(element, status){
        $.ajax({
            type: "POST",
            url: '../bitrix/templates/app/api/change_feed_app.php',
            data: {element: element, status: status},
            beforeSend: function () {
                NProgress.start();
            },
            complete: function () {
                NProgress.done();
            },
            success: function (res) {
                if(res.success){
                    loadApplication(element)
                }
                mainToast(5000, res.status, ``, res.result)
            },
            error: function (err) {
                mainToast(5000, "error", 'Ошибка загрузки!', err)
            }
        });
    }
    // document filter
    $('#filter_document').each(function () {
        let iblock = $('.document_list').data('iblock') ? $('.document_list').data('iblock') : null
        let filterParam = { iblock, section: null, date: null, sort: 'desc', type: '', PAGEN_1: 1 }
        let docName = $(this).find('input#filter_name')
        let sectionSelect = $(this).find('select#filter_section')
        let datePicker = $(this).find('input#filter_date')
        let sortButton = $(this).find('button#filter_sort');
        GetFilter(filterParam);
        // фильтр по названию
        $(docName).on('input', function () {
            if ($(this).val().length >= 3) {
                setTimeout(() => {
                    filterParam.name = $(this).val()
                    GetFilter(filterParam);
                }, 100)
            }
        })
        // филmтр по дате
        $(datePicker).on('input', function () {
            if ($(this).val().length >= 0) {
                filterParam.date = null
                GetFilter(filterParam);
            }
        })
        $(datePicker).datepicker({
            onSelect: function (formattedDate, date, inst) {
                if (date) {
                    filterParam.date = formattedDate;
                    GetFilter(filterParam);
                }
            }
        }).data('datepicker');
        // фильтр по разделам
        $(sectionSelect).select2({
            //minimumResultsForSearch: -1
        })
        $(sectionSelect).on('change', function () {
            if ($(this).val() == 'all') {
                filterParam.section = '#';
            } else {
                filterParam.section = $(this).val();
            }
            GetFilter(filterParam);
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
            filterParam.sort = sort
            GetFilter(filterParam)
        })
        // функция получения данных 
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
                        filterParam.PAGEN_1 = $(this).attr('data-pagenum');
                        GetFilter(filterParam);
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                    });
                    $('.act').on('click', function () {
                        filterParam.PAGEN_1 = $(this).attr('data-pagenum');
                        GetFilter(filterParam);
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                    });

                    $('[data-toggle="tooltip"]').tooltip({
                        animated: 'fade',
                        html: true
                    })
                    folderAnimation()
                },
                error: function (err) {
                    mainToast(5000, "error", 'Ошибка загрузки!', err)
                }
            });
        }
    })
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
        trigger: 'click',
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
    // modal
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
            if ($('input#app_form_persondata_18').is(':checked')) {
                $('input#app_form_persondata_19').show()
            } else {
                $('input#app_form_persondata_19').hide()
            }
            $('#app_form_departament').select2({
                language: "ru"
            });
            $('.modal_loader').fadeIn("slow");
        },
        onOpened: function () {
            $('.modal_loader').fadeOut("slow");
        },
        onClosing: function () { },
        onClosed: function () { },
        afterRender: function () { }
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

    // $('#app_form_departament').on('select2:select', function (e) {
    //     let data = {
    //         id: e.params.data.id
    //     }
    //     $.ajax({
    //         url: '/bitrix/templates/app/api/person.php',
    //         type: 'GET',
    //         data: data,
    //         //dataType: 'json',
    //         beforeSend: function () {
    //             // NProgress.start();
    //         },
    //         complete: function () {
    //             // NProgress.done();
    //         },
    //         success: function (res) {
    //             $('#person').html('<option value="#">Выберите должностное лицо</option>')
    //             if (res.result.length > 1) {
    //                 res.result.forEach(person => {
    //                     $('#person').append(`<option title="${e.params.data.text}" value="${person.ID}">${person.NAME}</option>`);
    //                 })
    //             } else {
    //                 $('#person').append(`<option title="${e.params.data.text}" value="${res.result[0].ID}">${res.result[0].NAME}</option>`);
    //             }
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //         }
    //     })
    // });
    $('#need_person').on('change', function () {
        if ($(this).is(':checked')) {
            $('#person').select2({
                language: "ru"
            });
        } else {
            $('#person').select2('destroy');
        }
    })
    // function getAddress(param, search = false) {
    //     ymaps.ready(function () {
    //         ymaps.geocode(param).then(function (res) {
    //             let obj = res.geoObjects.get(0),
    //                 error, hint;
    //             if (obj) {
    //                 switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
    //                     case 'exact':
    //                         break;
    //                     case 'number':
    //                     case 'near':
    //                     case 'range':
    //                         error = 'Неточный адрес, требуется уточнение';
    //                         hint = 'Уточните номер дома';
    //                         break;
    //                     case 'street':
    //                         error = 'Неполный адрес, требуется уточнение';
    //                         hint = 'Уточните номер дома';
    //                         break;
    //                     case 'other':
    //                     default:
    //                         error = 'Неточный адрес, требуется уточнение';
    //                         hint = 'Уточните адрес';
    //                 }
    //             } else {
    //                 error = 'Адрес не найден';
    //                 hint = 'Уточните адрес';
    //             }
    //             // Если геокодер возвращает пустой массив или неточный результат, то показываем ошибку.ц
    //             if (error) {
    //                 showMessage(error, hint);
    //             } else {
    //                 showResult();
    //             }
    //         }, function (err) {
    //             console.log(err)
    //         })
    //     })
    // }
    function showResult() {
        $('input#app_form_persondata_25').next('.error_message').remove()
    }
    function showMessage(error, hint) {
        $('input#app_form_persondata_25').next('.error_message').remove()
        $('input#app_form_persondata_25').after(`<span class="error_message">${error}, ${hint}</span>`)
    }
    // поиск адреса
    $('input#app_form_persondata_25').on('input', function () {
        if ($(this).val().length > 0) {
            let suggestView = new ymaps.SuggestView('app_form_persondata_25')
            suggestView.events.add("select", function (e) {
                if (e.get('item').value == $(this).val()) {
                    suggestView.destroy()
                }
            })
        }
    })
    // validate
    let activeTab = []
    $('#app_form_persondata_23').mask('+7 (000) 000-00-00', {
        onChange: function (cep) {
            $('#app_form_persondata_23').next('.error_message').remove()
        },
        onInvalid: function (val, e, f, invalid, options) {
            let error = invalid[0];
            $(e.target).next('.error_message').remove()
            $(e.target).after(`<span class="error_message">${error.p - 2} не валидный сивол!</span>`)
        }
    })
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    $('#app_form_persondata_24').on('input', function () {
        let valid = isEmail($(this).val())
        if (valid) {
            $(this).next('.error_message').remove()
        } else {
            $(this).next('.error_message').remove()
            $(this).after(`<span class="error_message">Не валидная е-почта!</span>`)
        }
    });
    $('#app_form_consent').each(function () {
        let form_tab = $(this).closest('.form_tab')
        let event = $(form_tab).find('.form_tab_event')
        if ($(this).is(':checked')) {
            $(form_tab).addClass('is_valid')
            $(event).html('<i class="fa fa-check"></i>')
        } else {
            $(that).removeClass('is_valid')
            $(event).html(tabNumber)
        }
    })
    function formTabValidation(el, valid=false){
        let tabNumber = $(el).data('event-num')
        let form_tab = $(el).closest('.form_tab')
        let event = $(form_tab).find('.form_tab_event')
        if (valid) {
            $(form_tab).addClass('is_valid')
            $(event).html('<i class="fa fa-check"></i>')
        } else {
            $(form_tab).removeClass('is_valid')
            $(event).html(tabNumber)
        }
    }
    // form tab line
    $('.app_form').each(function () {
        let that = this
        let textareaQuest = $(this).find('textarea[name="description"]')
        let textareaText = $(this).find('textarea[name="description_detail"]')
        let firstName = $(this).find('input[name="first_name"]')
        let name = $(this).find('input[name="name"]')
        let email = $(this).find('input[name="email"]')
        let address = $(this).find('input[name="address"]')
        let departament = $(this).find('#app_form_departament')
        let person = $(this).find('select#person')
        let check = $(this).find('input#app_form_persondata_18')
        let need_person = $(this).find('input#need_person')
        let consent = $(this).find('#app_form_consent')
        let button = $('.btn_submit')
        let inputStatus = []
        let textareaStatus = []
        let inputValidCount = 0

        
        if ($(check).is(':checked')) {
            if (inputStatus[0] == 'ok' && inputStatus[1] == 'ok' && inputStatus[2] == 'ok' && inputStatus[3] == 'ok' && inputStatus[4] == 'ok' && inputStatus[5] == 'ok' && inputStatus[6] == 'ok' && inputStatus[7] == 'ok') {
                formTabValidation(input, true)
            } else {
                formTabValidation(input)
            }
        } else {
            if (inputStatus[0] == 'ok' && inputStatus[1] == 'no' && inputStatus[2] == 'ok' && inputStatus[3] == 'ok' && inputStatus[4] == 'ok' && inputStatus[5] == 'ok' && inputStatus[6] == 'ok' && inputStatus[7] == 'ok') {
                formTabValidation(input, true)
            } else {
                formTabValidation(input)
            }
        }

        $(input).on('input', function(){
            if ($(input).val() && $(input).val().length == 0) {
                inputValidCount++
            }
            else {
                inputValidCount--
            }
            if($(input).val() && $(input).val().length == 0){
                console.log($('.form_tab.is_valid').length)
                formTabValidation(departament, true)
            }
        })
        // проверяем выбран ли департамент
        $(departament).on('change', function(){
            if($(departament).val() != '#'){
                formTabValidation(departament, true)
            }else{
                formTabValidation(departament)
            }
        })
        // проверяем выставлена ли галочка соглация на обработку персданных
        if ($(check).is(':checked')) {
            formTabValidation(check, true)
        } else {
            formTabValidation(check)
        }
        // console.log($('.form_tab.is_valid').length)
        if ($('.form_tab.is_valid').length >= 4) {
            $('.form_tab').addClass('is_valid')
            $('.form_submit').addClass('is_valid')
            $(button).prop("disabled", false)
        } else {
            $('.form_submit').removeClass('is_valid')
            $(button).prop("disabled", true)
        }
        
    })
    $('#app_form_persondata_19').suggestions({
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
                $('#app_form_persondata_20').val(manager[0]).parent('.group').children('label').addClass('is_active')
                $('#app_form_persondata_21').val(manager[1]).parent('.group').children('label').addClass('is_active')
                $('#app_form_persondata_22').val(manager[2]).parent('.group').children('label').addClass('is_active')
            }
            $('#app_form_persondata_25').val(suggestion.data.address.value).next('label').addClass('is_active')
        }
    });
    $('#app_form_persondata_24').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "EMAIL",
        onSelect: function(res) {
            $('#app_form_persondata_24').next('.error_message').remove()
        }
    });
    $('#app_form_persondata_20').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "NAME",
        onSelect: function(res) {
            
        }
    });
    $('#app_form_persondata_21').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "NAME",
        onSelect: function(res) {
            
        }
    });
    $('#app_form_persondata_22').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "NAME",
        onSelect: function(res) {
            
        }
    });
    // label change
    $('input#app_form_persondata_18').on('change', function () {
        let firstname = $('input#app_form_persondata_20')
        let name = $('input#app_form_persondata_21')
        let lastname = $('input#app_form_persondata_22')
        let email = $('input#app_form_persondata_24')
        let address = $('input#app_form_persondata_25')
        if ($(this).is(':checked')) {
            $(firstname).parent().children('label').text('Фамилия руководителя')
            $(name).parent().children('label').text('Имя руководителя')
            $(lastname).parent().children('label').text('Отчество руководителя')
            $(email).parent().children('label').text('Е-почта организации')
            $(address).parent().children('label').text('Адрес организации')
            $('input#app_form_persondata_19').attr('required', true)
            $('input#app_form_persondata_19').show()
        } else {
            $(firstname).parent().children('label').text('Фамилия')
            $(name).parent().children('label').text('Имя')
            $(lastname).parent().children('label').text('Отчество')
            $(email).parent().children('label').text('Е-почта')
            $(address).parent().children('label').text('Адрес')
            $('input#app_form_persondata_19').attr('required', false)
            $('input#app_form_persondata_19').hide()
        }
    })
    // label active
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
    // counter
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
    // let searchParams = { search: '', iblocktype: null, iblockid: null, PAGEN_1: 1 }
    // function getSearchResult(data) {
    //     $.ajax({
    //         url: '/bitrix/templates/app/api/search.php',
    //         type: 'GET',
    //         data: data,
    //         beforeSend: function () {
    //             NProgress.start();
    //         },
    //         complete: function () {
    //             NProgress.done();
    //         },
    //         success: function (res) {
    //             $('.search_result').html('')
    //             $('.search_result').show()
    //             let search_item = [...$(res)]
    //             let interVal = 0
    //             search_item.forEach((item) => {
    //                 interVal += 100
    //                 setTimeout(() => {
    //                     animateCSS(item, 'fadeInUp')
    //                     $('.search_result').append(item)
    //                 }, interVal)
    //             })
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //             mainToast(5000, "error", 'Ошибка загрузки!', thrownError)
    //         }
    //     })
    // }
    // $('.search_result').bind('DOMSubtreeModified', function () {
    //     $('.paginationjs-page').on('click', function () {
    //         searchParams.PAGEN_1 = $(this).attr('data-pagenum');
    //         getSearchResult(searchParams);
    //         $('html, body').animate({ scrollTop: 0 }, 'slow');
    //     });
    //     $('.act').on('click', function () {
    //         searchParams.PAGEN_1 = $(this).attr('data-pagenum');
    //         getSearchResult(searchParams);
    //         $('html, body').animate({ scrollTop: 0 }, 'slow');
    //     });
    // })
    // $('.search_form').on('submit', function (event) {
    //     // event.preventDefault()
    //     searchParams.search = $('input#search').val()
    //     searchParams.iblocktype = $('input[name="iblocktype"]:checked').val()
    //     searchParams.PAGEN_1 = 1
    //     getSearchResult(searchParams)
    // })
    // $('input[name="iblocktype"]').on('input', function () {
    //     searchParams.search = $('input#search').val()
    //     searchParams.iblocktype = $('input[name="iblocktype"]:checked').val()
    //     searchParams.PAGEN_1 = 1
    //     if ($('#search').val().length) {
    //         getSearchResult(searchParams)
    //     }
    // })
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
    function uploaderImg(addButton, addInput, imgList, reset = false, edit = false) {
        $(addButton).on('click', function () {
            $(addInput).trigger('click');
        })
        var maxFileSize = 5 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
        var queue = {};
        var imagesList = $(imgList);
        var filelist = $('.file_list').children().length;
        // 'detach' подобно 'clone + remove'
        var itemPreviewTemplate = imagesList.find('.item').detach();
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
            $(addInput).bind('change', function () {
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
    let filesArr = uploaderImg('.add_photo-item', '#js-photo-upload', '#uploadImagesList', false, false);
    function getNewToken(){
        grecaptcha.ready(function () {
            grecaptcha.execute('6Lf3hssZAAAAAK2SOCPR9V8zAbClunlgAlNjYLKT', { action: "homepage" })
            .then(async token => {
                document.getElementById('token').value = await token
            });
        });
    }
    getNewToken()
    $('.app_form').on('submit', function (event) {
        event.preventDefault();
        
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
                NProgress.start();
            },
            complete: function () {
                NProgress.done();
                //$('#modal_app_form').iziModal('close')
            },
            success: function (res) {
                getNewToken()
                mainToast(time = 5000, param = res.status, res, res.result)
            },
            error: function (err) {
                 mainToast(time = 5000, param = 'error', err, text = 'Обращение не отправлено!')
            }
        })
    });
    // folder animation
    function folderAnimation(){
        $(".js_toggle-folder").on('click', function () {
            let top = 0
            let icon = $(this).find('.fa-folder')
            let iconOpen = $(this).find('.fa-folder-open')
            
            $(".js_toggle-folder").not(this).each(function () {
                $(this).parent().removeClass("active");
                $(this).removeClass("active");
                tl.to($(this).find('.fa-folder'), { opacity: 1, duration: 0.01 })
                tl.to($(this).find('.fa-folder-open'), { opacity: 0, duration: 0.01 })   
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