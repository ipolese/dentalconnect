<?php

function style(){
    return '
        * {
            font-family: "DM Sans",sans-serif;
            font-size: 16px;
            font-weight: 400;
            font-style: normal;
            line-height: 19px;
            text-decoration: none;
            text-transform: none;
            letter-spacing: 0px;
            color: #4b4b4b;
        }

        .title{
            font-size: 24px;
            font-weight: bold;
            color: #0038ae;
        }

        hr{
            border: none;
            border-bottom: 1px solid #0038ae;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .label{
            font-size: 16px;
            font-weight: bold;
            color: #0038ae;
        }

        .label_in_border{
            font-size: 16px;
            font-weight: bold;
            color: #0038ae;
            background: #fff;
            position: absolute;
            width: auto !important;
            padding: 0 5px;
            margin-top: -10px;
        }

        .logo-container {
            text-align: left;
            margin-top: -25px;
            margin-left: -25px;
        }

        .code-container {
            text-align: right;
            margin-top: -25px;
            margin-right: -35px;
        }

        .group{
            border: 1px solid #0038ae;
            border-radius: 15px;
            padding: 0 15px 10px 15px;
            margin-bottom: 15px;
        }

        .row_inline_simple,
        .row {
            width: 100% !important;
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .one-third-width {
            width: 30%;
            margin-right: 2%;
            margin-top: 15px;
            display:inline-block;
            vertical-align:top;
        }

        .two-thirds-width {
            width: 62%;
            margin-right: 3%;
            margin-top: 15px;
            display:inline-block;
            vertical-align:top;
        }

        .one-four-width {
            width: 22%;
            margin-right: 2%;
            margin-top: 15px;
            display:inline-block;
            vertical-align:top;
        }

        .half-width {
            width: 46%;
            margin-right: 3%;
            margin-top: 15px;
            display:inline-block;
            vertical-align:top;
        }

        .full-width {
            width: 95%;
            margin-right: 3%;
            margin-top: 15px;
            display:inline-block;
            vertical-align:top;
        }

        .input_view{
            width: 100% !important;
            border: none !important;
            border-bottom: 1px solid #d9e0e3 !important;
            border-radius: 0px !important;
            font-size: 16px !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 10px 0;
        }

        .levantamento_periapical_group{
            text-align: center;
            padding: 10px 0;
        }

        .checkbox_label {
            padding: 7px 0;
            position: relative;
            padding-left: 16px;
            text-align: left;
            cursor: pointer;
            line-height: 14px;
        }
        
        .checkbox_label:before {
            content: "";
            position: absolute;
            left: 2;
            top: 0;
            width: 14px;
            height: 14px;
            border: 1px solid #0038ae;
            border-radius: 4px;
        }
        
        input[type="checkbox"]:checked {
            content: "\2713";
            font-size: 14px;
            text-align: center;
            line-height: 10px;
            background-color: #0038ae;
            border: 1px solid #0038ae;
        }

        .row_inline_simple label.checkbox_label {
            width: auto !important;
            font-size: 12px !important;
            font-weight: 600;
            margin-right: 20px;
        }
    ';
}