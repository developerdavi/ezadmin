<!DOCTYPE html>
<html>
<head>
	<title>Ez SQL Admin</title>
	<link rel="stylesheet" type="text/css" href="css/materialize.css">
  <link href="css/material-icons.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style type="text/css">
  	.materialize-textarea {
  		color: rgba(0,0,0,0.87);
  	}
    .tabs .indicator {
      position: absolute;
      bottom: 0;
      height: 2px;
      background-color: #263238;
      will-change: left, right;
    }
    .tabs .tab a:hover, .tabs .tab a.active {
      background-color: transparent;
      color: #000000;
    }
    .tabs .tab a {
      color: rgba(0, 0, 0, 0.7);
      display: block;
      width: 100%;
      height: 100%;
      padding: 0 24px;
      font-size: 14px;
      text-overflow: ellipsis;
      overflow: hidden;
      -webkit-transition: color .28s ease, background-color .28s ease;
      transition: color .28s ease, background-color .28s ease;
    }
    .tabs .tab.disabled a, .tabs .tab.disabled a:hover {
      color: rgba(0, 0, 0, 0.4);
      cursor: default;
    }
    .tabs .tab a:focus, .tabs .tab a:focus.active {
      background-color: rgba(19, 19, 19, 0);
      outline: none;
    }
  </style>
</head>
