import axios from "axios"
import { useEffect, useState } from "react";
import { Navigate,  useNavigate, useParams } from "react-router-dom";

export default function EditUser () {
    const Navigate = useNavigate();
    const [inputs, setInputs] = useState([]);
    const {id} = useParams();

    useEffect(() => {
        getUsers();
    }, []);

    function getUsers() {

        axios.get('http://localhost:81/api/users/${id]').then(function(response){
            console.log(response.data);
            setInputs(response.data);
    });
}
    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }


    const handleSubmit = (event) => {
        event.prevent.default();

        axios.put('http://localhost:81/api/users/${id]/edit', inputs).then(function(response){
            console.log(response.data);
            Navigate('/');
    });
}


    return(
        <div>
        <h1>Edit user</h1>
        <form onSubmit={handleSubmit}>
            <table cellSpacing="10">
                <tbody>
                    <tr>
                        <th>
                            <label>Name: </label>
                        </th>
                        <td>
                            <input value={inputs.name} type="text" name="name" onChange={handleChange} />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label>Email: </label>
                        </th>
                        <td> 
                            <input value={inputs.email} type="text" name="email" onChange={handleChange} />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label>Mobile: </label>
                        </th>
                        <td>
                            <input value={inputs.mobile} type="text" name="mobile" onChange={handleChange} />
                        </td>
                    </tr>
                    <tr>
                        <td colSpan="2" align ="right">
                            <button>Save</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
)
}