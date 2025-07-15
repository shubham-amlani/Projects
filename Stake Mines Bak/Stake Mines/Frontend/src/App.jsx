import { useEffect, useState } from "react";
import { createBrowserRouter, RouterProvider } from "react-router-dom";
import Form from "./components/Form.jsx";
import "./App.css";
import GamePage from "./components/GamePage";

function App() {
  const [isAuthenticated, setisAuthenticated] = useState();
  useEffect(() => {
    const checkAuthentication = async () => {
      try {
        const response = await fetch("http://localhost:3000/api/auth/check");
        const result = await response.json();
        console.log(result.authenticated)
        if (result.authenticated) {
          setisAuthenticated(true);
        } else {
          setisAuthenticated(false);
        }
      } catch (error) {
        console.error("Error checking authentication:", error);
      }
    };

    checkAuthentication();
  }, []);
  return (
    <>
    {isAuthenticated && <GamePage/>}
    {!isAuthenticated && <Form setisAuthenticated={setisAuthenticated}/>}
    </>
  );
}

export default App;
