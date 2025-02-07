import '../page_css/Basic.css'
import {HelperQuery,buttonActive,useButton} from "../methods/HelperQuery";
import {useEffect} from "react";
import {checkRole} from "../methods/ConsumerAuthorizeMethod";
import {getGEO} from "../methods/GetGEO";
import {callTaxi} from "../methods/CallTaxi";

export const HomePage = () => {
    getGEO()
    checkRole();
    useEffect(() => {
        buttonActive()
    },[])
    return(
        <div className=''>
            <h1 className="order-h1">Заказ такси</h1>

            <div className="order-form">
                <h1>Выберите место на карте или введите адресс</h1>
                <div className='city-div'>
                    <input name='city' className='city' placeholder='Введите город'/>
                </div>

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
                <div>
                    <label className="custom-checkbox kids">
                        <input type='checkbox' className="has-kids"/>
                        <span></span> Дети
                    </label>
                </div>
                <div className='payment-method'>
                    <label>Выберите метод оплаты</label><br/>
                    <select className='payment-select'>
                        <option>Наличные</option>
                        <option>Банковская карта</option>
                    </select>
                </div>
                <button className="order-submit-button" onClick={useButton}>Рассчитать цену</button>
                <div className='order-price'></div>
                <button className="call-car-button order-submit-button" id='' onClick={callTaxi}>Вызвать машину</button>
                <div className='consumer-order-data'></div>
                <div className="error consumer-order-error"></div>
                <HelperQuery/>
            </div>
        </div>
    )
}