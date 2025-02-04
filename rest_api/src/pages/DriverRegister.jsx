import '../page_css/Register.css'
import '../page_css/Basic.css'
import {driverRegisterMethod} from "../methods/DriverRegisterMethod";


export const DriverRegister = () => {
    return (
        <div className="style-container">
            <div className="driver-register-container">
                <h1>Регистрация водителя</h1>
                <div className="driver-register-form">
                    <form onSubmit={driverRegisterMethod}>
                        <div className="form-elements">
                            <label>Номер телефона</label><br/>
                            <input name="phone" type="text" placeholder="Введите номер телефона"/>
                            <div className="error phone-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>ФИО</label><br/>
                            <input name="name" type="text" placeholder="Введите ФИО"/>
                            <div className="error name-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>Пароль</label><br/>
                            <input name="password" type="password" placeholder="Введите пароль"/>
                            <div className="error password-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>Модель авто</label><br/>
                            <input name="model" type="text" placeholder="Введите модель авто"/>
                            <div className="error model-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>Марка авто</label><br/>
                            <input name="brand" type="text" placeholder="Введите марку авто"/>
                            <div className="error brand-error"></div>
                        </div>
                        <button className="submit-button" type="submit">Войти</button>
                    </form>
                    <div className="consumer-register">
                        <div className="driver-authorize">
                            <a href='/driver_authorize'>Войти как водитель</a>
                        </div>
                        <div className="register">
                        <a href='/register'>Войти как пользователь</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )

}