import {DriverAuthorizeMethod,checkRole} from "../methods/DriverAuthorize";
export function DriverHome(){
    checkRole()
    return(
        <div>
            <div>
                <h1>Водительская панель</h1>
                <div className='order-form'>

                </div>
            </div>
        </div>
    )
}