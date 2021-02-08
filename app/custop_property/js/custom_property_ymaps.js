
let myMap;
let myPlacemark;

// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);
function init() {
    let ymCoords = document.getElementById('ymaps_object_values_coords');
    let ymAddress = document.getElementById('ymaps_object_values_address');
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map").
    myMap = new ymaps.Map("ymaps", {
        // При инициализации карты обязательно нужно указать
        // её центр и коэффициент масштабирования.
        center: [43.020603, 44.681888], // владикавказ
        zoom: 12
    }, {
        searchControlProvider: "yandex#search"
    });
    // Загружаем ранее сохраненные данные
    if(ymCoords.value.length > 0){
        let saveCoords = ymCoords.value.split(',')
        let lat = Number(saveCoords[0])
        let lon = Number(saveCoords[1])
        myPlacemark = createPlacemark([lat, lon])
        myMap.geoObjects.add(myPlacemark);
        myPlacemark.events.add('dragend', function () {
            getAddress(myPlacemark.geometry.getCoordinates());
        });
        getAddress([lat, lon])
    }
    // Слушаем клик на карте.
    myMap.events.add('click', function (e) {
        var coords = e.get('coords');
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        }else{
            myPlacemark = createPlacemark(coords);
            myMap.geoObjects.add(myPlacemark);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark.events.add('dragend', function () {
                getAddress(myPlacemark.geometry.getCoordinates());
            });
        }
        getAddress(coords)
    });
    // Создание метки.
    function createPlacemark(coords) {
        return new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
        }, {
            preset: 'islands#lightBlueDotIcon',
            draggable: true
        });
    }
    // Определяем адрес по координатам (обратное геокодирование).
    function getAddress(coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        return ymaps.geocode(coords).then(async res => {
            var firstGeoObject = res.geoObjects.get(0);
            myPlacemark.properties
                .set({
                    // Формируем строку с данными об объекте.
                    iconCaption: [
                        // Название населенного пункта или вышестоящее административно-территориальное образование.
                        firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                        // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                        firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                    ].filter(Boolean).join(', '),
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: await firstGeoObject.getAddressLine()
                });
                ymCoords.value = coords
                ymAddress.value = firstGeoObject.getAddressLine()
        });
    }
}