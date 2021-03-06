<?php
    header("Content-type: text/css; charset: UTF-8");
?>

body {
    margin: 0;
    padding: 0;
    background-color: #908181;
}

header, main {
    width: 80%;
    margin: 0 auto;
    background-color: white;
}

h1 {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    font-size: 7vw;
    text-align: center;
}

h2 {
    font-size: 2vw;
}

p {
 font-size: 1.2vw;
}

a {
    text-decoration: none;
    color: black;
}

.pris {
    font-size: 2vw;
    float: left;
    margin: 10px;
}

main .produktruta {
    box-sizing: content-box;
    width: 18%;
    text-align: end;
    padding: 5px;
    padding-top: 35px;
    margin-right: 5px;
    margin-left: 5px;
    margin-top: 10px;
    border: 2px solid #2024a5;
    background-color: grey;
}

.varukorg {
    width: 20%;
    height: 40px;
    padding: 10px;
    background-color: black;
    color: white;
}

main {
   display: flex;
   flex-wrap:wrap;
   padding-bottom: 10px;
}

article {
    width: 100%;
}

.gallery {
    margin: 10px;
    width: 60%;
    float: left;
}

.gallery .Productimg {
width: 100%
}

.Productimg:hover {
    opacity: 0.4;
}

.productImage {
    width: 95%;
    height: 125px;
    object-fit: contain;
}

.readmore {
    width: 32%;
    padding: 10px;
    box-sizing: content-box;
}

.button_group{
  box-sizing: content-box;
    display: flex;
}
button {
	font-size: 8px;	
    font-weight: 1px;
	border: 0;
	padding: 1em 0;
  width: 3%;
  height: 2%;
  
  border: 1px solid #000;
    
}
button:nth-child(2){
	margin: 0.5em;
}
button:hover{
  background: rgba(0,0,0,0.3);
}

#counter{
	font-size: 8px;
	text-align: center;
  width: 4%;
  height: 2%;
  margin-left: 2px;
  margin-right: 2px;
  display: block;
 
  padding: 1em 0;
   border: 1px solid #000;
}




@media (max-width: 893px) {
    .gallery .small-images {
        flex: 50%;
    }

    .gallery .small-images > img {
        box-sizing: border-box;
        width: 42%;
        height: 15%;
        margin: 0;
    }

    .gallery .small-images .small_left{
        margin-left: 5px;
  }
  .gallery .small-images .margin {
    margin-left:1px;
}
.varukorg {
    width: 21%;
    height: 31px;
    padding: 10px;
    font-size: 1.5vw;
    background-color: black;
    color: white;
}
}

@media (max-width: 768px) {
    .gallery .small-images {
        flex: 50%;
    }

    .gallery .small-images > img {
        box-sizing: border-box;
        width: 42%;
        height: 15%;
        margin: 0;
    }

    .gallery .small-images .small_left{
        margin-left: 5px;
  }
  .gallery .small-images .margin {
    margin-left:1px;
}
.varukorg {
    width: 21%;
    height: 31px;
    padding: 10px;
    font-size: 1.5vw;
    background-color: black;
    color: white;
}
}