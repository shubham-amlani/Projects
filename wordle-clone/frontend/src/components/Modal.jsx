import React from "react";
import "../styles/Modal.css";

const Modal = ({ message, onClose, onNewGame }) => {
  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <h2>{message}</h2>
        <div className="btns-div">
        <button onClick={onClose} className="close-btn">
          Close
        </button>
        <button onClick={onNewGame} className="new-game-btn">New Game</button>
        </div>
      </div>
    </div>
  );
};

export default Modal;
