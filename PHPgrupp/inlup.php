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

.gallery .big-image {
width: 100%
}

.big-image:hover {
    opacity: 0.4;
}

.gallery .small-images {
    display: flex;
    flex-wrap: wrap;
}

.gallery .small-images > img {
    box-sizing: border-box;
    flex: 24%;
    width: 24%;
    height: 15%;
}

.gallery .small-images .margin {
    margin-left:5px;
}
.thumbBorder {
    border: 2px solid grey;
}

.productimg {
    width: 95%;
    height: 125px;
    object-fit: contain;
}

.readmore {
    background-color: #fff;
}

/*.fas {
    position: absolute;
    top: 155px;
    left: 94px;
    color: #88887e;
    font-size: 6vw;
    z-index: -1;
}*/

#overlay {
    background-color: rgba(0, 0, 0, 0.88);
    position: fixed;
    top:0;
    left: 0;
    bottom: 0;
    right: 0;
    display: none;
}
#overlay.visible {
    display: block;
}

#overlay .overlay-image {
    width: 55%;
    border: 1px solid black;
    margin: 100px auto;
    display: block;
}

#prevImg, #nextImg { 
    position: absolute;
    top: 50%;
    color: white;
    font-size: 3vw;
    background-color: transparent;
    border: 2px solid white;
    border-radius: 50%;
    opacity: 0.5;
}

#prevImg:hover, #nextImg:hover {
    color: pink;
    border: 2px solid pink;
    border-radius: 50%;

}

 #nextImg {
    left: auto;
    right: 15px;
}
/*
.button_group{
  box-sizing: content-box;
 
  display: flex;
}
button {
	font-size: 8px;	
  /*font-weight: 1px;*/
	border: 0;
	padding: 1em 0;
  width: 3%;
  height: 2%;
  background: ; 
  border: 1px solid #000;
  -webkit-transition:.2s;  
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
  display block;
  background:;
  padding: 1em 0;
   border: 1px solid #000;
}
*/



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