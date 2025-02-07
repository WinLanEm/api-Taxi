export function getGEO(){
    const cityContainer = document.querySelector('.city-div')
    navigator.geolocation.getCurrentPosition(
    (position) => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        validateGEO(latitude,longitude).then(data => {
            const cityInput = document.querySelector('.city')
            cityInput.value = data.address.city
        })
    },
    (error) => {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                console.error("Пользователь отказался предоставить доступ к местоположению.");
                cityContainer.style.display = 'block'
                break;
            case error.POSITION_UNAVAILABLE:
                console.error("Информация о местоположении недоступна.");
                cityContainer.style.display = 'block';
                break;
            case error.TIMEOUT:
                console.error("Время запроса на получение местоположения истекло.");
                cityContainer.style.display = 'block'
                break;
            default:
                console.error("Произошла неизвестная ошибка.");
                cityContainer.style.display = 'block'
        }
    }
)}
async function validateGEO(lat,lon){
    const validateLat = encodeURIComponent(lat)
    const validateLon = encodeURIComponent(lon)
    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${validateLat}&lon=${validateLon}`
    try{
        const response = await fetch(url,{
            method:'GET'
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error(`Ошибка получения адреса: ${error}`)
        return null
    }
}
export function getDriverGEO(){
    const cityContainer = document.querySelector('.driver-location-div')
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            validateGEO(latitude,longitude).then(data => {
                const cityInput = document.querySelector('.driver-location')
                cityInput.value = data.display_name
                setDriverGEO(data.address.road,data.address.house_number,data.address.city)
            })
        },
        (error) => {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.error("Пользователь отказался предоставить доступ к местоположению.");
                    cityContainer.style.display = 'block'
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.error("Информация о местоположении недоступна.");
                    cityContainer.style.display = 'block';
                    break;
                case error.TIMEOUT:
                    console.error("Время запроса на получение местоположения истекло.");
                    cityContainer.style.display = 'block'
                    break;
                default:
                    console.error("Произошла неизвестная ошибка.");
                    cityContainer.style.display = 'block'
            }
        }
        )}
async function setDriverGEO(road,house,city){
    const url = 'http://127.0.0.1/api/backend/drivers/update.php'
    const finalAddress = city + ', ' + road + ', ' + house
    const data = {
        location:finalAddress
    }
    const response = await fetch(url,{
        credentials:'include',
        method:'PATCH',
        body:JSON.stringify(data)
    })
    const result = await response.json()
    return result
}