

let anyChecked = false
let carClass = "";
export const buttonActive = () => {

    setTimeout(() => {
        const economyCheckbox = document.querySelector('.economyCheckbox')
        const businessCheckbox = document.querySelector('.businessCheckbox')
        const comfortCheckbox = document.querySelector('.comfortCheckbox')
        let isEconomomy = false
        let isComfort = false
        let isBusiness = false
        economyCheckbox.addEventListener('change',function(){
            isEconomomy = true
            carClass = 'economy'
            isComfort = false
            isBusiness = false
            anyChecked = this.checked
            businessCheckbox.checked = false
            comfortCheckbox.checked = false

        })
        businessCheckbox.addEventListener('change',function(){
            isComfort = false;
            carClass = 'business'
            isEconomomy = false
            isBusiness = true
            anyChecked = this.checked
            economyCheckbox.checked = false
            comfortCheckbox.checked = false

        })
        comfortCheckbox.addEventListener('change',function(){
            isBusiness = false;
            carClass = 'comfort'
            isComfort = true
            isEconomomy = false
            anyChecked = this.checked
            businessCheckbox.checked = false
            economyCheckbox.checked = false

        })
    },1000)
}

export const useButton = () => {
    const button = document.querySelector('.order-submit-button')
    const finalAddress = document.querySelector('.final-address')
    const sourceAddress = document.querySelector('.source-address')
    const error = document.querySelector('.error')
    button.addEventListener('click',(() => {
        if(!finalAddress || !sourceAddress || !anyChecked){
            error.textContent = 'Выберите все параметры'
        }else if(finalAddress && sourceAddress && anyChecked){
            error.textContent = ""
            makeOrder(carClass,finalAddress.value,sourceAddress.value)
        }
    }))
}

const helper = (query,parent,helperDiv) => {
    parent.addEventListener('click',(e) => {
        if(e.target.classList.contains('final-click')){
            const div = e.target
            helperDiv.value = div.textContent
            parent.innerHTML = ''
            parent.style.display = 'none'
        }
    })
    const city = document.querySelector('.city').value
    const token = 'bb0deb05ec3f11946014ff516b96e85578ff31a7'
    fetch("http://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address",{
        method: 'POST',
        mode: 'cors',
        headers:{
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body:JSON.stringify({query:city + " " + query})
    }).then(response => response.json())
        .then(data => {
            parent.style.display = 'block'
            parent.innerHTML = ``
            data.suggestions.forEach((item) => {
                const street = item.data.street_with_type
                const houseType = item.data.house_type_full
                const houseNumber = item.data.house
                const hostalCode = item.data.postal_code
                if(!street || !houseType || !houseNumber){
                    return
                }
                const duplicate = document.querySelectorAll('.final-click')
                duplicate.forEach((el) => {
                    if(el.id === houseNumber){
                        el.remove()
                    }
                })
                parent.innerHTML += `
                <div id='${houseNumber}' class="final-click">${street}, ${houseType} ${houseNumber}</div>
                `

            })
        })
}
export const HelperQuery = () => {
    setTimeout(() => {
        const parentFinal = document.querySelector('.final-helper')
        const finalAddress = document.querySelector('.final-address')
        finalAddress.addEventListener('input',() => {
            const value = finalAddress.value? finalAddress.value: "Москва"
            helper(value,parentFinal,finalAddress)
        })
        const sourceAddress = document.querySelector('.source-address')
        const parentSource = document.querySelector('.source-helper')
        sourceAddress.addEventListener('input',() => {
            const value = sourceAddress.value? sourceAddress.value: "Москва"
            helper(value,parentSource,sourceAddress)
        })
    },1000)
}
export async function makeOrder(carClass,sourceAddress,finalAddress){
    let city = sourceAddress.split(',')
    let finalCity = ''
    let megaFinalCity = ''
    if(city[0] === 'Россия'){
        finalCity = city[1]
    }else{
        finalCity = city[0]
    }
    if(finalCity.includes('г ')){
        megaFinalCity = finalCity.replace(/г /g,'')
    }else{
        megaFinalCity = finalCity
    }
    const GEOCity = document.querySelector('.city').value
    const encodeGEOCity = encodeURIComponent(GEOCity)
    const hasKidsInput = document.querySelector('.has-kids')
    const hasKids = hasKidsInput.checked
    const orderPrice = document.querySelector('.order-price')
    orderPrice.style.display = 'block'
    orderPrice.textContent = 'Идет рассчет стоимости...'
    translateText(encodeGEOCity,'ru','en')
        .then(enCity => {

            getWeather(enCity).then(item => {
                let data = {
                    car_class:carClass.replaceAll(/\s+/g, ''),
                    has_kids:hasKids,
                }
                data.weather = item.weather? item.weather:'warm'
                workLoad().then(activeUsers => {
                    data.active_drivers = activeUsers? activeUsers.drivers:1
                    data.active_consumers = activeUsers?activeUsers.consumers:1
                    const validateSource = sourceAddress.replace('дом', '')
                    const validateFinal = finalAddress.replace('дом','')
                    getKilometers(validateSource,validateFinal,GEOCity).then(distance => {
                        data.kilometers = distance? distance:0
                        calculatePrice(data).then(price => {
                            if(price === null){
                                orderPrice.textContent = 'Сервис временно не доступен'
                                return
                            }
                            orderPrice.textContent = price + '₽'
                            const call = document.querySelector('.call-car-button')
                            call.style.display = 'block'
                            call.id = price
                        })
                    })
                })

            })
        })

}
async function translateText(text, sourceLang = "ru", targetLang = "en") {
    const url = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(text)}&langpair=${sourceLang}|${targetLang}`;

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        const result = await response.json();
        return result.responseData.translatedText;
    } catch (error) {
        console.error("Ошибка при переводе текста:", error);
        return null;
    }
}
async function getWeather(city){
    const encodedCity = encodeURIComponent(city)
    const url = `http://127.0.0.1/api/backend/weather/?city=${encodedCity}`
    try{
        const response = await fetch(url,{
            method:'GET',
            headers:{
                'Accept': 'application/json'
            },
            credentials:'include',
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при запросе погоды', error)
        return null
    }
}
async function workLoad(){
    const url = 'http://127.0.0.1/api/backend/workload/index.php'
    try{
        const response = await fetch(url,{
            headers:{
                'Accept':'application/json',
            },
            method:"GET",
            credentials:'include',
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при запросе загруженности', error)
        return null
    }
}
async function getKilometers(sourceAddress,finalAddress,city){
    const encodeSource = encodeURIComponent(sourceAddress)
    const encodeFinal = encodeURIComponent(finalAddress)
    const encodeCity = encodeURIComponent(city);
    const url = `http://127.0.0.1/api/backend/kilometers/index.php?source_address=${encodeSource}&final_address=${encodeFinal}&city=${encodeCity}`
    try{
        const response = await fetch(url,{
            'headers':{
                'Accept':'application/json'
            },
            credentials:'include',
            method:"GET",
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при запросе расстояния', error)
        return null
    }
}
async function calculatePrice(data){
    const url = `http://127.0.0.1/api/backend/price/index.php?weather=${data.weather}&car_class=${data.car_class}
    &active_drivers=${data.active_drivers}&active_consumers=${data.active_consumers}&kilometers=${data.kilometers}
    &has_kids=${data.has_kids}`
    try{
        const response = await fetch(url,{
            headers:{
                'Accept':'application/json'
            },
            credentials:'include',
            method:"GET",
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при запросе цены', error)
        return null
    }
}
