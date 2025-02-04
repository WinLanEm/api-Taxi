import { YMaps, Map, Placemark, SearchControl} from "@pbe/react-yandex-maps";
import { useState } from "react";

export const GeocodeMap = () => {
    const [coordinates, setCoordinates] = useState([55.75, 37.62]); // Начальные координаты (Москва)
    const [address, setAddress] = useState('Загрузка адреса...');
    const apiKey = '29931adb-ff09-41a2-8726-533060b9c12b'; // Замените на ваш API ключ

    // Функция для получения адреса
    const getAddress = async (latitude, longitude) => {
        try {
            const response = await fetch(`https://geocode-maps.yandex.ru/1.x/?apikey=${apiKey}&geocode=${longitude},${latitude}&format=json`);
            const data = await response.json();
            const finalAddress = document.querySelector('.final-address')

            // Проверяем, есть ли данные в ответе
            if (data.response?.GeoObjectCollection?.featureMember?.length > 0) {
                const foundAddress = data.response.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.text;
                setAddress(foundAddress);
                finalAddress.value = foundAddress
                const helperDiv = document.querySelector('.final-helper')
                helperDiv.innerHTML = ''
                helperDiv.style.display = 'none'

            } else {
                setAddress('Адрес не найден');
            }
        } catch (error) {
            console.error('Ошибка при получении адреса:', error);
            setAddress('Ошибка при получении адреса');
        }
    };

    // Обработчик завершения перетаскивания метки
    const handleDragEnd = (event) => {
        const newCoordinates = event.get('target').geometry.getCoordinates();
        setCoordinates(newCoordinates);
        getAddress(newCoordinates[0], newCoordinates[1]); // Передаем широту и долготу
    };

    return (
        <div>
            <YMaps>
                <Map defaultState={{ center: coordinates, zoom: 12 }}
                     style={{ width: '100%', height: '400px' }}
                     options={{ suppressMapOpenBlock: true }}>
                    <Placemark
                        geometry={coordinates}
                        options={{ draggable: true }}
                        onDragEnd={handleDragEnd}
                    />
                </Map>
            </YMaps>
        </div>
    );
};

