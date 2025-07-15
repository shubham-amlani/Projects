import React from "react";
import Navbar from './Navbar'
import Grid from './Grid'
import Sidebar from './Sidebar'

const GamePage = () => {
  return (
    <>
      <Navbar />
      <div className="flex mx-auto my-[5vh] justify-center items-center flex-col-reverse md:flex-row">
        <Sidebar />
        <Grid />
      </div>
    </>
  );
};

export default GamePage;
