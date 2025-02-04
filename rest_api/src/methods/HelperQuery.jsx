
export const buttonActive = () => {
    setTimeout(() => {
        const button = document.querySelector('.order-submit-button')
        const finalAddress = document.querySelector('.final-address')
        const sourceAddress = document.querySelector('.source-address')
        const economyCheckbox = document.querySelector('.economyCheckbox')
        const businessCheckbox = document.querySelector('.businessCheckbox')
        const comfortCheckbox = document.querySelector('.comfortCheckbox')
        let carClass = "";
        let isEconomomy = false
        let isComfort = false
        let isBusiness = false
        let anyChecked = false
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

        const error = document.querySelector('.error')
        button.addEventListener('click',(() => {
            if(!finalAddress || !sourceAddress || !anyChecked){
                error.textContent = 'Выберите все параметры'
            }else if(finalAddress && sourceAddress && anyChecked){
                error.textContent = ""
                makeOrder(carClass,finalAddress.value,sourceAddress.value)
            }
        }))
    },1000)
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
    const token = 'bb0deb05ec3f11946014ff516b96e85578ff31a7'
    fetch("http://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address",{
        method: 'POST',
        mode: 'cors',
        headers:{
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body:JSON.stringify({query:query})
    }).then(response => response.json())
        .then(data => {
            parent.style.display = 'block'
            parent.innerHTML = ``
            data.suggestions.forEach((item) => {
                const value = item.value
                const divText = `${value}`
                parent.innerHTML += `
                <div class="final-click">${divText}</div>
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
async function makeOrder(carClass,sourceAddress,finalAddress){
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

    translateText(megaFinalCity,'ru','en')
        .then(enCity => {
            const data = {
                carClass:carClass,
                sourceAddress:sourceAddress,
                finalAddress:finalAddress,
                city:enCity,
            }
        })
    getWeather('Moscow').then(data => {
        console.log(data)
    })


    // await fetch('http://127.0.0.1/api/backend/weather',{
    //     method:"GET",
    // }).then((response) => {
    //     return response.json()
    // }).then(data => {
    //     console.log(data)
    // })
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
    const url = `http://127.0.0.1/api/backend/weather?city=${encodedCity}`
    try{
        const response = await fetch(url,{
            method:'GET',
            headers:{
                'Accept': 'application/json'
            }
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        console.log(result)
        return result
    }catch (error){
        console.error('Ошибка при запросе погоды', error)
        return null
    }
}

