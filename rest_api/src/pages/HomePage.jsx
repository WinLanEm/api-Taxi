import '../page_css/Basic.css'
import {HelperQuery,buttonActive} from "../methods/HelperQuery";
import {GeocodeMap} from "../methods/GeocodeMap";
import {useEffect} from "react";
import {useState} from "react";
import {checkRole} from "../methods/ConsumerAuthorizeMethod";

export const HomePage = () => {
    checkRole();
    const [userData, setUserData] = useState(null);
    const [error, setError] = useState(null);
    useEffect(() => {
        buttonActive()
    },[])
    return(
        <div className=''>
            <h1 className="order-h1">Заказ такси</h1>

            <div className="order-form">
                <h1>Выберите место на карте или введите адресс</h1>
                <GeocodeMap/>
                <div className="address">
                    <input name="source-address" placeholder="Откуда едете" className="source-address"/>
                    <input name="final-address" placeholder="Куда едете" className="final-address"/>
                </div>
                <div className="address">
                    <div className='helper-div source-helper'>

                    </div>
                    <div className='helper-div final-helper'>

                    </div>
                </div>
                <div className="checkbox-container">
                    <label className="custom-checkbox">
                        <input type="checkbox" className='economyCheckbox'/>
                        <span></span> Эконом
                    </label>
                    <label className="custom-checkbox">
                        <input type="checkbox" className='businessCheckbox'/>
                        <span></span> Бизнес
                    </label>
                    <label className="custom-checkbox">
                        <input type="checkbox" className='comfortCheckbox'/>
                        <span></span> Комфорт
                    </label>
                </div>
                <button className="order-submit-button">Вызвать машину</button>
                <div className="error consumer-order-error"></div>
                <HelperQuery/>
            </div>
        </div>
    )
}