import mongoose from "mongoose";

mongoose.connect("mongodb://localhost:27017/mines");

const db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', ()=>{
    console.log("Database connection successful!");
})

export default mongoose;