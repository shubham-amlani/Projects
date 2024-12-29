import React, { useState, useEffect } from "react";
import { Helmet } from "react-helmet";
import "./App.css";
import Grid from "./components/Grid.jsx";
import Keyboard from "./components/Keyboard.jsx";

const App = () => {
  const [grid, setGrid] = useState(
    Array(6)
      .fill("")
      .map(() => Array(5).fill({ letter: "", status: "" }))
  );
  const [currentRow, setCurrentRow] = useState(0);
  const [currentColumn, setCurrentColumn] = useState(0);
  const [solution, setSolution] = useState("REACT"); // Hardcoded solution, can be dynamic
  const [gameOver, setGameOver] = useState(false);

  const validateWord = async (word) => {
    try {
      const response = await fetch(
        `https://api.dictionaryapi.dev/api/v2/entries/en/${word}`
      );
      return response.ok;
    } catch (error) {
      console.error("Network error occurred:", error);
      return false;
    }
  };

  const displayAlert = (message) => {
    const alertBox = document.createElement("div");
    alertBox.innerText = message;
    alertBox.className = "alert-box";
    document.body.appendChild(alertBox);

    setTimeout(() => {
      alertBox.remove();
    }, 1500);
  };

  const handleKeyPress = async (key) => {
    if (gameOver) return;

    const newGrid = [...grid];
    const currentRowData = newGrid[currentRow];

    if (key === "BACKSPACE" || key === "Backspace") {
      if (currentColumn > 0) {
        const colIndex = currentColumn - 1;
        currentRowData[colIndex] = { letter: "", status: "" };
        setCurrentColumn(colIndex);
      }
    } else if (key === "ENTER" || key === "Enter") {
      if (currentColumn < 5) {
        displayAlert("Not enough letters!");
        return;
      }

      const currentWord = currentRowData.map((cell) => cell.letter).join("");

      const isValidWord = await validateWord(currentWord);
      if (!isValidWord) {
        displayAlert("Word not found!");
        return;
      }

      // Evaluate correctness of the current word
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
        if (solutionArr.includes(cell.letter)) {
          solutionArr[solutionArr.indexOf(cell.letter)] = null;
          return { ...cell, status: "present" }; // Yellow
        }
        return { ...cell, status: "absent" }; // Gray
      });

      newGrid[currentRow] = finalRow;
      setGrid(newGrid);

      if (currentWord === solution) {
        displayAlert("You win!");
        setGameOver(true);
      } else if (currentRow === grid.length - 1) {
        displayAlert(`Game Over! The word was: ${solution}`);
        setGameOver(true);
      } else {
        setCurrentRow(currentRow + 1);
        setCurrentColumn(0);
      }
    } else if (key.match(/^[A-Z]$/) && currentColumn < 5) {
      currentRowData[currentColumn] = { letter: key, status: "" };
      setCurrentColumn(currentColumn + 1);
    }
  };

  useEffect(() => {
    const handleKeyDown = (event) => {
      let key = event.key.toUpperCase();
      if (key.match(/^[A-Z]$/) || key === "BACKSPACE" || key === "ENTER") {
        handleKeyPress(key);
      }
    };

    window.addEventListener("keydown", handleKeyDown);
    return () => window.removeEventListener("keydown", handleKeyDown);
  }, [grid, currentRow, currentColumn]);

  return (
    <div className="main-container">
      <Helmet>
        <link
          href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
          rel="stylesheet"
        />
      </Helmet>
      <h1 className="heading">Wordle</h1>
      <Grid
          grid={grid}
          currentRow={currentRow}
          currentColumn={currentColumn}
        />
      <Keyboard onKeyPress={handleKeyPress} />
    </div>
  );
};

export default App;
