import React, { useState, useEffect } from "react";
import { Helmet } from "react-helmet";
import "./App.css";
import Grid from "./components/Grid.jsx";
import { generate } from "random-words";
import Keyboard from "./components/Keyboard.jsx";
import Modal from "./components/Modal.jsx";

const App = () => {
  const [grid, setGrid] = useState(
    Array(6)
      .fill("")
      .map(() => Array(5).fill({ letter: "", status: "" }))
  );
  const [currentRow, setCurrentRow] = useState(0);
  const [currentColumn, setCurrentColumn] = useState(0);
  const [gameOver, setGameOver] = useState(false);
  const [solution, setSolution] = useState("");
  const [modalMessage, setModalMessage] = useState("");
  const [showModal, setShowModal] = useState(false);
  const [keyboardColors, setKeyboardColors] = useState({});

  const updateKeyboardColors = (evaluatedRow) => {
    const newColors = { ...keyboardColors };

    evaluatedRow.forEach((cell) => {
      const { letter, status } = cell;

      if (status === "correct") {
        newColors[letter] = "green";
      } else if (status === "present" && newColors[letter] !== "green") {
        newColors[letter] = "yellow";
      } else if (status === "absent" && !newColors[letter]) {
        newColors[letter] = "gray";
      }
    });

    setKeyboardColors(newColors);
  };

  useEffect(() => {
    const getRandomWord = () => {
      setSolution(generate({ minLength: 5, maxLength: 5 }).toUpperCase());
    };

    getRandomWord(); // Generate the word on component mount
  }, []);

  const validateWord = async (word) => {
    try {
      const response = await fetch(
        `https://api.dictionaryapi.dev/api/v2/entries/en/${word}`
      );
      if (response.status === 404) {
        return false;
      }
      if (response.ok) {
        return true;
      }
      console.error("Unexpected error:", response.status);
      return false;
    } catch (error) {
      console.error("Network error occurred:", error);
      return false;
    }
  };

  const onKeyPress = async (key) => {
    if (gameOver || showModal) return; // Prevent actions when the modal is open

    const newGrid = [...grid];
    const currentRowData = newGrid[currentRow];

    if (key === "BACKSPACE" || key === "Backspace") {
      if (currentColumn > 0) {
        const colIndex = currentColumn - 1;
        currentRowData[colIndex] = { letter: "", status: "" };
        setCurrentColumn(colIndex);
      }
    } else if (key === "ENTER" || key === "Enter") {
      const currentWord = currentRowData.map((cell) => cell.letter).join("");

      if (currentWord.length < 5) {
        displayAlert("Too short");
        return;
      } else {
        const isValidWord = await validateWord(currentWord);

        if (!isValidWord) {
          displayAlert("Word not found!");
          return;
        } else {
          const solutionArr = solution.split("");
          
          const evaluatedRow = currentRowData.map((cell, index) => {
            if (cell.letter === solutionArr[index]) {
              solutionArr[index] = null; // Mark as matched
              return { ...cell, status: "correct" }; // Green
            }
            return cell;
          });
          
          const finalRow = evaluatedRow.map((cell) => {
            if (cell.status === "correct") return cell;
            const letterIndex = solutionArr.indexOf(cell.letter);
            if (letterIndex !== -1) {
              solutionArr[letterIndex] = null; // Mark as matched
              return { ...cell, status: "present" }; // Yellow
            }
            return { ...cell, status: "absent" }; // Gray
          });          

          newGrid[currentRow] = finalRow;
          setGrid(newGrid);
          updateKeyboardColors(finalRow);

          if (currentWord === solution) {
            setModalMessage("You win!");
            setGameOver(true);
            setShowModal(true);
          } else if (currentRow === grid.length - 1) {
            setModalMessage(`You lost! The word was: ${solution}`);
            setGameOver(true);
            setShowModal(true);
          } else {
            setCurrentRow(currentRow + 1);
            setCurrentColumn(0);
          }
        }
      }
    } else if (key.match(/[A-Z]/)) {
      const newRow = newGrid[currentRow];
      if (currentColumn < 5 && newRow[currentColumn].letter === "") {
        newRow[currentColumn] = { letter: key, status: "" };
        setGrid(newGrid);
        setCurrentColumn(currentColumn + 1);
      }
    }
  };

  const displayAlert = (message) => {
    const alertBox = document.createElement("div");
    alertBox.innerText = message;
    alertBox.className = "alert-box";
    document.body.appendChild(alertBox);

    setTimeout(() => {
      alertBox.remove();
    }, 500);
  };

  const handleNewGame = () => {
    setGameOver(false);
    setShowModal(false);
    setGrid(
      Array(6)
        .fill("")
        .map(() => Array(5).fill({ letter: "", status: "" }))
    );
    setCurrentRow(0);
    setCurrentColumn(0);
    setModalMessage("");
    setSolution(generate({ minLength: 5, maxLength: 5 }).toUpperCase());
    setKeyboardColors({});
  };

  const handleCloseModal = () => {
    setShowModal(false);
  };

  useEffect(() => {
    const handleKeyDown = (event) => {
      let key = event.key;

      if (key.match(/^[a-zA-Z]$/)) {
        key = key.toUpperCase();
      }

      if (key.match(/^[A-Z]$/) || key === "Backspace" || key === "Enter") {
        onKeyPress(key);
      }
    };

    window.addEventListener("keydown", handleKeyDown);

    return () => {
      window.removeEventListener("keydown", handleKeyDown);
    };
  }, [grid, currentRow, currentColumn]);

  const handleGiveUp = () => {
    if (!gameOver) {
      setModalMessage("Game over! The word was: " + solution);
      setGameOver(true);
      setShowModal(true);
    }
  };

  useEffect(() => {
    const handleKeyDown = (event) => {
      if (!gameOver) return; // Only handle Enter key if game has not started and modal is shown

      if (event.key === "Enter") {
        handleNewGame(); // Trigger new game
      }
    };

    window.addEventListener("keydown", handleKeyDown);

    return () => {
      window.removeEventListener("keydown", handleKeyDown);
    };
  }, [gameOver, showModal]);

  
  return (
    <>
      <div className="main-container">
        <Helmet>
          <link rel="preconnect" href="https://fonts.googleapis.com" />
          <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin />
          <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet"
          />
        </Helmet>
        <h1 className="heading">Wordle</h1>
        <Grid grid={grid} currentRow={currentRow} currentColumn={currentColumn} />
        <Keyboard onKeyPress={onKeyPress} keyboardColors={keyboardColors}/>
        <div className="btns-box">
        <button onClick={handleGiveUp} className="give-up-btn">Give Up</button>
        <button onClick={handleNewGame} className="new-game-btn">New Game</button>
        </div>
        {showModal && (
          <Modal
            message={modalMessage}
            onClose={handleCloseModal}
            onNewGame={handleNewGame}
          />
        )}
      </div>
    </>
  );
};

export default App;
