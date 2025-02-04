import {DriverAuthorizeMethod,checkRole} from "../methods/DriverAuthorize";


export function DriverAuthorize(){
    return(
        <div>
            <div className="consumer-authorize-container">
                <h1>Авторизация водителя</h1>
                <div className="consumer-form">
                    <form onSubmit={DriverAuthorizeMethod}>
                        <div className="form-elements">
                            <label>Номер телефона</label><br/>
                            <input name="phone" type="text" placeholder="Введите номер телефона"/>
                            <div className="error phone-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>Пароль</label><br/>
                            <input name="password" type="password" placeholder="Введите пароль"/>
                            <div className="error password-error"></div>
                        </div>
                        <button className="submit-button" type="submit">Войти</button>
                    </form>
                    <div className="register-driver">
                        <div className="driver-authorize">
                            <a href='/authorize'>Войти как пользователь</a>
                        </div>
                        <div className="register">
                            <a href='/driver_register'>Зарегистрироваться</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}