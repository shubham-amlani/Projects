import React, { useState } from 'react'
import '../Form.css'

const Form = ({setisAuthenticated}) => {
  const [username, setUsername] = useState('')
  const data = {username: username};
  console.log(data);

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch("http://localhost:3000/api/auth", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ username })
      });
      if (response.ok) {
        setisAuthenticated(true);
      } else {
        console.error("Authentication failed");
      }
    } catch (error) {
      console.error("Error authenticating user:", error);
    }
  };

    return (
        <div className="form-container">
          <form className="username-form" onSubmit={handleSubmit} method='POST'>
            <label htmlFor="username" className="form-label">Username</label>
            <input
              type="text"
              id="username"
              className="form-input"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              placeholder="Enter your username"
            />
            <button type="submit" className="form-button">Submit</button>
          </form>
        </div>
      );
}

export default Form
