<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;

if (!defined('ABSPATH'))
    exit;

class Custom_Tab_Section extends Widget_Base
{
    public function get_name()
    {
        return 'custom_tab_section';
    }
    public function get_title()
    {
        return 'Custom Tab Section';
    }
    public function get_icon()
    {
        return 'eicon-tabs';
    }
    public function get_categories()
    {
        return ['general'];
    }
    protected function register_controls()
    {
        // Static HTML widget - no controls needed
    }

    protected function render()
    { ?>
        <style>
     
            /* Tab Navigation */
            .sec-tabs-nav {
                margin-bottom: 0;
            }

            .sec-tabs-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                gap: 20px;
            }

            .sec-tab-item {
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 20px;
                cursor: pointer;
                transition: all 0.3s ease;
                width: 20%;
                border-radius: var(--M, 12px);
                border: 1px solid var(--Golbal-others-border-3, #D7DBE4);
                background: var(--Golbal-backgrounds-global-bg-3, #F2F5FA);
                margin-bottom: 20px;
            }

            .sec-tab-item:hover {
                background: #e8ecf1;
            }

            .sec-tab-item.active {
                border-radius: var(--M, 12px) var(--M, 12px) var(--NA, 0) var(--NA, 0);
                background: #FFFFFF;
                border: 1px solid #fff;
                margin-bottom: 0 !important;
            }

            .sec-tab-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                flex-shrink: 0;
            }

            .sec-tab-icon svg {
                width: 40px;
                height: 40px;
                color: #06283D;

            }

            .sec-tab-item:not(.active) .sec-tab-icon svg {
                color: #5F6F94;
            }

            .sec-tab-item.active .sec-tab-icon {
                color: #fff;
            }

            .sec-tab-text {
                color: var(--Golbal-text-text-3, #5C5C5C);
                font-size: 16px;
                font-weight: 500;
                line-height: 150%;
            }

            .sec-tab-item.active .sec-tab-text {
                color: #06283D;
            }

            /* Tab Content Panels */
            .sec-tabs-content {
                position: relative;
            }

            .sec-tab-panel {
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .sec-tab-panel.active {
                display: block;
                opacity: 1;
            }

            .sec-panel-inner {
                display: flex;
                gap: 20px;
                border-radius: 0 var(--M, 12px) var(--M, 12px) var(--M, 12px);
                background: #FFF;
                padding: 20px;
                align-items: center;
                flex-direction: row-reverse;
            }

            .sec-panel-image {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .sec-panel-image img {
                width: 100%;
                height: auto;
                border-radius: 12px;
            }

            .sec-panel-text {
                flex: 1;
            }

            .sec-panel-text h4 {
                color: var(--Golbal-text-text-1, #06283D);
                font-size: 28px;
                font-style: normal;
                font-weight: 600;
                line-height: 122%;
                margin-bottom: 0;
            }

            .sec-panel-text p {
                font-size: 18px;
                font-weight: 400;
                line-height: 144.444%;
                margin: 12px 0;
            }

            .sec-panel-btn {
                display: inline-block;
                padding: 12px 24px;
                background: transparent;
                border: 1px solid #0073aa;
                color: #0073aa;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.3s ease;
                margin-top: 10px;
            }

            .sec-panel-btn:hover {
                background: #0073aa;
                color: #fff;
            }

            /* Dropdown label and select-brand - hidden on desktop */
            .sec-dropdown-label,
            .sec-select-brand {
                display: none;
            }

            /* Mobile styles for dropdown (up to 1024px) */
            @media (max-width: 1024px) {
                .sec-tabs-nav {
                    margin-bottom: 30px;
                    position: relative;
                }

                .sec-dropdown-label {
                    display: inline-block;
                    font-size: 18px;
                    font-family: Geometria-Medium, sans-serif;
                    padding-right: 15px;
                    color: #000000;
                }

                .sec-select-brand {
                    display: inline-block;
                    color: #06283d;
                    width: auto;
                    font-size: 18px;
                    text-decoration: underline;
                    font-family: Geometria-Medium, sans-serif;
                    cursor: pointer;
                    position: relative;
                }

                .sec-select-brand:after {
                    content: "";
                    position: absolute;
                    right: auto;
                    margin-left: 15px;
                    width: 20px;
                    height: 20px;
                    display: inline-block;
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none'%3E%3Cpath d='M3 4.5L6 7.5L9 4.5' stroke='%2306283D' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: contain;
                    -webkit-transition: transform 0.4s ease-in-out;
                    -moz-transition: transform 0.4s ease-in-out;
                    -ms-transition: transform 0.4s ease-in-out;
                    -o-transition: transform 0.4s ease-in-out;
                    transition: transform 0.4s ease-in-out;
                }

                .sec-select-brand.angle-icon:after {
                    transform: rotate(180deg);
                }

                .sec-tabs-list {
                    display: none;
                    position: absolute;
                    left: 0;
                    top: 100%;
                    bottom: auto;
                    z-index: 1000;
                    background: #fff;
                    width: 100%;
                    border-radius: 0;
                    -webkit-box-shadow: 0 1px 2px -2px #000000a1;
                    -moz-box-shadow: 0 1px 2px -2px #000000a1;
                    box-shadow: 0 1px 2px -2px #000000ed;
                    margin-top: 10px;
                    border: 1px solid #e6ebf2;
                    padding: 0;
                    white-space: normal;
                    overflow: visible;
                    /* max-height: 400px; */
                    overflow-y: auto;
                    flex-direction: column;
                    gap: 0;
                }

                .sec-tabs-list.show-dropdown {
                    display: flex;
                }

                .sec-tab-item {
                    display: block;
                    width: 100%;
                    margin-right: 0;
                    margin-bottom: 0;
                    padding: 12px 15px;
                    border-bottom: 1px solid #e6ebf2;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                    border-top: none;
                    flex-direction: row;
                    gap: 12px;
                }

                .sec-tab-item:last-child {
                    border-bottom: none;
                }

                .sec-tab-item.active {
                    border-radius: 0;
                    margin-bottom: 0;
                    border-bottom: 1px solid #e6ebf2;
                }

                .sec-panel-inner {
                    flex-direction: column;
                }

                .sec-panel-image {
                    flex: 0 0 100%;
                    max-width: 100%;
                }
            }

            /* Desktop styles - show tabs, hide dropdown */
            @media (min-width: 1025px) {
                .sec-tabs-list {
                    display: flex !important;
                }

                .sec-dropdown-label,
                .sec-select-brand {
                    display: none !important;
                }
            }
        </style>

        <div class="sec-tabs-wrapper">
            <!-- Tab Navigation -->
            <div class="sec-tabs-nav">
                <label class="sec-dropdown-label">Security Features</label>
                <span class="sec-select-brand">System hardening and network-level protection</span>
                <ul class="sec-tabs-list">
                    <li class="sec-tab-item active" data-target="secPanel0">
                        <span class="sec-tab-icon">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.9349 16.5042C15.4586 16.0162 15.017 15.4956 14.6133 14.9462L10.713 21.0409H3.33334V32.7604H10.0716V34.7136H7.10938V36.6668H14.987V34.7136H12.0247V32.7604H18.763V21.0409H13.0317L15.9349 16.5042ZM10.8203 26.1844H6.26302V24.2312H10.8203V26.1844ZM26.3125 6.1696V4.65063H24.2715C23.3796 4.65063 22.502 4.49437 21.6641 4.18641C21.071 3.96895 20.5137 3.68313 20 3.3335C19.4863 3.68313 18.9284 3.96895 18.3346 4.18641C17.5002 4.49396 16.6178 4.65113 15.7285 4.65063H13.6875V6.1696C13.6875 10.735 16.0925 14.9253 20 17.2321C23.9076 14.9253 26.3125 10.735 26.3125 6.1696ZM19.1608 12.4415L16.5755 9.85667L17.957 8.47573L19.1608 9.67957L22.043 6.79659L23.4245 8.17753L19.1608 12.4415ZM36.6667 32.7604V21.0409H29.2869L25.3867 14.9468C24.9844 15.4944 24.5423 16.0146 24.0651 16.5042L26.9683 21.0409H21.237V32.7604H27.9753V34.7136H25.013V36.6668H32.8906V34.7136H29.9284V32.7604H36.6667ZM28.724 26.1844H24.1667V24.2312H28.724V26.1844Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <span class="sec-tab-text">System hardening and network-level protection</span>
                    </li>
                    <li class="sec-tab-item" data-target="secPanel1">
                        <span class="sec-tab-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path
                                    d="M28.9778 15.4932L27.5208 14.4266C27.5687 13.9769 27.5687 13.5234 27.5208 13.0738L28.9792 12.0057C29.3391 11.7393 29.5891 11.3504 29.6819 10.9124C29.7748 10.4744 29.7042 10.0175 29.4833 9.62794L28.2625 7.471C28.0422 7.07523 27.6805 6.7774 27.2497 6.63727C26.819 6.49713 26.3513 6.52506 25.9403 6.71544L24.3014 7.46822C23.9539 7.22031 23.5859 7.0024 23.2014 6.81683L23.0208 4.97516C22.9799 4.52644 22.7728 4.10923 22.44 3.80547C22.1072 3.50172 21.6728 3.33337 21.2222 3.3335H18.7778C17.8431 3.3335 17.0708 4.03905 16.9778 4.97794L16.7972 6.81822C16.4153 7.00155 16.0472 7.21961 15.6972 7.46961L14.0611 6.71683C13.6506 6.52465 13.1823 6.49563 12.7512 6.63565C12.32 6.77567 11.9582 7.07426 11.7389 7.471L10.5153 9.62933C10.2947 10.0192 10.2245 10.4763 10.3179 10.9143C10.4113 11.3524 10.6619 11.7411 11.0222 12.0071L12.4792 13.0738C12.4313 13.5234 12.4313 13.9769 12.4792 14.4266L11.0208 15.4946C10.6609 15.761 10.411 16.1499 10.3181 16.5879C10.2252 17.026 10.2958 17.4829 10.5167 17.8724L11.7375 20.0293C11.9578 20.4251 12.3196 20.7229 12.7503 20.8631C13.181 21.0032 13.6488 20.9753 14.0597 20.7849L15.6986 20.0321C16.0486 20.2821 16.4167 20.4988 16.7986 20.6835L16.9792 22.5252C17.0201 22.9739 17.2273 23.3911 17.5601 23.6949C17.8929 23.9986 18.3272 24.167 18.7778 24.1668H21.2222C22.157 24.1668 22.9292 23.4613 23.0222 22.5224L23.2028 20.6821C23.5847 20.4988 23.9528 20.2807 24.3028 20.0307L25.9403 20.7835C26.3507 20.9755 26.8187 21.0045 27.2498 20.8648C27.6808 20.7251 28.0427 20.427 28.2625 20.0307L29.4861 17.8724C29.706 17.482 29.7757 17.0248 29.6821 16.5866C29.5885 16.1485 29.338 15.7596 28.9778 15.4932ZM20 17.2224C18.0847 17.2224 16.5278 15.6641 16.5278 13.7502C16.5278 11.8363 18.0847 10.2779 20 10.2779C21.9153 10.2779 23.4722 11.8363 23.4722 13.7502C23.4722 15.6641 21.9153 17.2224 20 17.2224Z"
                                    fill="currentColor" />
                                <path
                                    d="M9.58334 29.7224C11.501 29.7224 13.0556 28.1678 13.0556 26.2502C13.0556 24.3325 11.501 22.7779 9.58334 22.7779C7.66569 22.7779 6.11112 24.3325 6.11112 26.2502C6.11112 28.1678 7.66569 29.7224 9.58334 29.7224Z"
                                    fill="currentColor" />
                                <path
                                    d="M12.0139 31.1113H7.15279C6.14003 31.112 5.16897 31.5147 4.45285 32.2308C3.73672 32.9469 3.33408 33.918 3.33334 34.9307V35.6252C3.33334 36.2002 3.80001 36.6668 4.37501 36.6668H14.7917C15.0679 36.6668 15.3329 36.5571 15.5282 36.3617C15.7236 36.1664 15.8333 35.9014 15.8333 35.6252V34.9307C15.8326 33.918 15.43 32.9469 14.7138 32.2308C13.9977 31.5147 13.0267 31.112 12.0139 31.1113Z"
                                    fill="currentColor" />
                                <path
                                    d="M30.4167 29.7224C32.3343 29.7224 33.8889 28.1678 33.8889 26.2502C33.8889 24.3325 32.3343 22.7779 30.4167 22.7779C28.499 22.7779 26.9445 24.3325 26.9445 26.2502C26.9445 28.1678 28.499 29.7224 30.4167 29.7224Z"
                                    fill="currentColor" />
                                <path
                                    d="M32.8472 31.1113H27.9861C26.9734 31.112 26.0023 31.5147 25.2862 32.2308C24.5701 32.9469 24.1674 33.918 24.1667 34.9307V35.6252C24.1667 36.2002 24.6333 36.6668 25.2083 36.6668H35.625C35.9013 36.6668 36.1662 36.5571 36.3616 36.3617C36.5569 36.1664 36.6667 35.9014 36.6667 35.6252V34.9307C36.6659 33.918 36.2633 32.9469 35.5472 32.2308C34.8311 31.5147 33.86 31.112 32.8472 31.1113Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <span class="sec-tab-text">Role-based access control with multi-level permissions</span>
                    </li>
                    <li class="sec-tab-item" data-target="secPanel2">
                        <span class="sec-tab-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path
                                    d="M25.1289 34.1027C22.2953 34.1027 19.5778 32.9771 17.5741 30.9735C15.5704 28.9699 14.4448 26.2525 14.4448 23.419C14.4448 20.5855 15.5704 17.868 17.5741 15.8644C19.5778 13.8608 22.2953 12.7352 25.1289 12.7352C26.7594 12.7322 28.3684 13.1067 29.8299 13.8292V6.32495C29.8255 5.53295 29.5088 4.77467 28.9488 4.21463C28.3887 3.65459 27.6304 3.33798 26.8384 3.3335H6.32487C5.53284 3.33798 4.77453 3.65459 4.21448 4.21463C3.65442 4.77467 3.3378 5.53295 3.33331 6.32495V33.6754C3.3378 34.4674 3.65442 35.2257 4.21448 35.7857C4.77453 36.3457 5.53284 36.6623 6.32487 36.6668H26.8384C27.6304 36.6623 28.3887 36.3457 28.9488 35.7857C29.5088 35.2257 29.8255 34.4674 29.8299 33.6754V33.5557L29.4539 33.1797C28.0919 33.7842 26.619 34.0985 25.1289 34.1027ZM9.74379 10.1711H23.4195C23.7595 10.1711 24.0856 10.3062 24.326 10.5466C24.5665 10.787 24.7016 11.1131 24.7016 11.4532C24.7016 11.7932 24.5665 12.1193 24.326 12.3597C24.0856 12.6001 23.7595 12.7352 23.4195 12.7352H9.74379C9.40375 12.7352 9.07765 12.6001 8.83721 12.3597C8.59677 12.1193 8.46169 11.7932 8.46169 11.4532C8.46169 11.1131 8.59677 10.787 8.83721 10.5466C9.07765 10.3062 9.40375 10.1711 9.74379 10.1711ZM9.74379 17.0087H13.1627C13.5027 17.0087 13.8288 17.1438 14.0693 17.3842C14.3097 17.6246 14.4448 17.9507 14.4448 18.2908C14.4448 18.6308 14.3097 18.9569 14.0693 19.1973C13.8288 19.4377 13.5027 19.5728 13.1627 19.5728H9.74379C9.40375 19.5728 9.07765 19.4377 8.83721 19.1973C8.59677 18.9569 8.46169 18.6308 8.46169 18.2908C8.46169 17.9507 8.59677 17.6246 8.83721 17.3842C9.07765 17.1438 9.40375 17.0087 9.74379 17.0087ZM13.1627 26.4104H9.74379C9.40375 26.4104 9.07765 26.2753 8.83721 26.0349C8.59677 25.7945 8.46169 25.4684 8.46169 25.1284C8.46169 24.7883 8.59677 24.4623 8.83721 24.2218C9.07765 23.9814 9.40375 23.8463 9.74379 23.8463H13.1627C13.5027 23.8463 13.8288 23.9814 14.0693 24.2218C14.3097 24.4623 14.4448 24.7883 14.4448 25.1284C14.4448 25.4684 14.3097 25.7945 14.0693 26.0349C13.8288 26.2753 13.5027 26.4104 13.1627 26.4104ZM36.2917 34.5814C36.0513 34.8214 35.7254 34.9563 35.3857 34.9563C35.0459 34.9563 34.7201 34.8214 34.4797 34.5814L29.8812 29.9831C28.2208 31.1876 26.1673 31.7221 24.1303 31.4799C22.0933 31.2377 20.2224 30.2367 18.8907 28.6764C17.559 27.1161 16.8643 25.1112 16.9452 23.0615C17.0261 21.0118 17.8767 19.0679 19.3272 17.6174C20.7777 16.167 22.7217 15.3165 24.7715 15.2356C26.8212 15.1547 28.8262 15.8493 30.3865 17.181C31.9468 18.5126 32.9479 20.3834 33.1901 22.4204C33.4323 24.4573 32.8978 26.5107 31.6932 28.1711L36.2917 32.7694C36.5318 33.0098 36.6666 33.3356 36.6666 33.6754C36.6666 34.0151 36.5318 34.341 36.2917 34.5814Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <span class="sec-tab-text">Tamper-proof audit logs and user activity monitoring</span>
                    </li>
                    <li class="sec-tab-item" data-target="secPanel3">
                        <span class="sec-tab-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path
                                    d="M33.737 24.8828H23.9713C22.3558 24.8828 21.0416 26.1969 21.0416 27.8124V33.7368C21.0416 35.3523 22.3558 36.6665 23.9713 36.6665H33.737C35.3525 36.6665 36.6666 35.3523 36.6666 33.7368V27.8124C36.6666 26.1969 35.3525 24.8828 33.737 24.8828ZM29.8307 31.7186C29.8307 32.2584 29.3939 32.7603 28.8541 32.7603C28.3144 32.7603 27.8776 32.2584 27.8776 31.7186V29.7655C27.8776 29.2258 28.3144 28.789 28.8541 28.789C29.3939 28.789 29.8307 29.2258 29.8307 29.7655V31.7186ZM3.33331 8.1414C3.33331 11.3466 9.7852 13.0242 16.0937 13.0242C22.4023 13.0242 28.8541 11.3466 28.8541 8.1414C28.8541 1.73086 3.33331 1.73086 3.33331 8.1414Z"
                                    fill="currentColor" />
                                <path
                                    d="M26.5104 13.0245C24.0885 14.3135 20.0391 14.9776 16.0937 14.9776C12.1484 14.9776 8.09894 14.3135 5.67706 13.0245C4.23175 12.2628 3.33331 11.2862 3.33331 10.0948V16.0941C3.33331 19.2972 9.7852 20.9769 16.0937 20.9769C17.903 20.9769 19.7788 20.8342 21.4483 20.5616C22.4584 17.4159 25.3773 15.0525 28.8541 15.0525V10.0948C28.8541 11.2862 27.9556 12.2628 26.5104 13.0245Z"
                                    fill="currentColor" />
                                <path
                                    d="M16.0937 22.93C12.1484 22.93 8.09894 22.2659 5.67706 20.9769C4.23175 20.2152 3.33331 19.2386 3.33331 18.0472V23.9065C3.33331 27.1096 9.7852 28.7893 16.0937 28.7893C17.0775 28.7893 18.1254 28.7437 19.0885 28.6626V27.8128C19.0885 26.224 19.863 24.8237 21.0416 23.9315V22.93C21.0416 22.8055 21.0726 22.6892 21.0785 22.5661C19.511 22.8028 17.7699 22.93 16.0937 22.93Z"
                                    fill="currentColor" />
                                <path
                                    d="M19.0885 33.7372V30.6193C18.126 30.7011 17.0762 30.7424 16.0937 30.7424C12.1484 30.7424 8.09894 30.0783 5.67706 28.7893C4.23175 28.0276 3.33331 27.051 3.33331 25.8597V31.719C3.33331 34.9221 9.7852 36.6668 16.0937 36.6668C17.3631 36.6668 18.6981 36.5955 19.9212 36.4608C19.3958 35.6821 19.0885 34.745 19.0885 33.7372ZM28.8541 17.0707C25.6181 17.0707 22.9948 19.694 22.9948 22.93H26.901C26.901 21.8513 27.7754 20.9769 28.8541 20.9769C29.9329 20.9769 30.8073 21.8513 30.8073 22.93H34.7135C34.7135 19.694 32.0902 17.0707 28.8541 17.0707Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <span class="sec-tab-text">Offline mode support for high-security deployments</span>
                    </li>
                    <li class="sec-tab-item" data-target="secPanel4">
                        <span class="sec-tab-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path
                                    d="M4.74185 13.3151C5.08638 12.6967 5.81538 12.4109 6.48696 12.618L6.62987 12.6704L6.63304 12.672L6.77119 12.7387C7.43238 13.1063 7.72155 13.917 7.41429 14.6299L7.41588 14.6315C6.68453 16.3302 6.31546 18.1342 6.31546 20.0033C6.31552 21.8725 6.68448 23.6765 7.41588 25.3752L7.62549 25.8437C9.88307 30.624 14.6844 33.6861 20.0048 33.6863L20.5526 33.6752C22.9882 33.5787 25.3498 32.8296 27.3965 31.5141L26.1468 31.2028C25.3442 31.0019 24.8593 30.1909 25.0607 29.3926L25.1052 29.2465C25.3628 28.5325 26.1225 28.118 26.8709 28.3065L31.2075 29.3895L31.3171 29.418L31.3361 29.4371C31.934 29.6418 32.3395 30.2015 32.3397 30.8408V35.1758C32.3397 35.9966 31.6693 36.6668 30.8486 36.6668C30.0282 36.6665 29.3576 35.9964 29.3576 35.1758V33.7943C26.6109 35.6546 23.3702 36.6652 20.0048 36.6652C16.7387 36.6674 13.5431 35.7117 10.8172 33.9134C8.09113 32.1149 5.9539 29.5547 4.67198 26.5519C3.78318 24.4801 3.33344 22.2734 3.33337 20.0033C3.33337 17.7324 3.7841 15.5258 4.67357 13.4532L4.74185 13.3151Z"
                                    fill="currentColor" />
                                <path
                                    d="M20.6114 3.34461C23.6638 3.45448 26.6319 4.4009 29.1877 6.08693C31.9139 7.88537 34.0509 10.4455 35.3329 13.4485L35.5742 14.0153H35.5536C36.2901 15.9217 36.6667 17.9317 36.6667 19.997C36.6667 22.268 36.216 24.4746 35.3265 26.5471C35.0813 27.1116 34.5361 27.4474 33.9562 27.4474C33.7093 27.4483 33.4656 27.3893 33.2479 27.2728C33.03 27.156 32.8442 26.9869 32.7081 26.7805C32.5718 26.574 32.4898 26.3362 32.4683 26.0898C32.4468 25.8436 32.486 25.5956 32.5842 25.3689L32.8414 24.7274C33.402 23.2184 33.6846 21.6326 33.6846 19.997C33.6846 18.3612 33.4021 16.7757 32.8414 15.2666L32.5842 14.6251C30.4253 9.57781 25.4872 6.31426 19.9953 6.314C17.3677 6.31302 14.8015 7.07088 12.602 8.48467L13.8533 8.79748L13.9993 8.84195C14.7136 9.09934 15.1283 9.8591 14.9394 10.6077C14.8416 10.9902 14.5957 11.3201 14.2566 11.5223C13.9598 11.6991 13.6125 11.7676 13.2737 11.7176L13.1292 11.6891L8.7926 10.6045C8.12686 10.4397 7.66535 9.84241 7.66518 9.15953V4.82454C7.66518 4.00377 8.33555 3.33355 9.15623 3.3335C9.97695 3.3335 10.6473 4.00374 10.6473 4.82454V6.20443C13.4022 4.33665 16.659 3.33205 20 3.3335L20.6114 3.34461Z"
                                    fill="currentColor" />
                                <path
                                    d="M26.104 13.9614C26.6892 13.4842 27.5545 13.5181 28.1 14.063C28.6453 14.6081 28.6803 15.4738 28.2032 16.059L28.1 16.1717L18.8837 25.3848C18.5951 25.6733 18.2138 25.823 17.831 25.823H17.8198C17.4852 25.8229 17.1526 25.7081 16.8814 25.4864L16.7687 25.3848L12.4305 21.0498C11.8489 20.4685 11.8494 19.5225 12.4305 18.941C13.0121 18.3597 13.9592 18.3597 14.5408 18.941L17.8246 22.2248L25.9912 14.063L26.104 13.9614Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <span class="sec-tab-text">Regular updates aligned with modern practices</span>
                    </li>
                </ul>
            </div>

            <!-- Tab Content Panels -->
            <div class="sec-tabs-content">
                <div class="sec-tab-panel active" id="secPanel0">
                    <div class="sec-panel-inner">
                        <div class="sec-panel-image">
                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
                                alt="System hardening and network-level protection">
                        </div>
                        <div class="sec-panel-text">
                            <h4>i2V's video management system (VMS)</h4>
                            <p>i2V is engineered to run in closed, air-gapped, or high-security networks — with hardened
                                configurations, strict firewall compatibility, and no external cloud dependencies.</p>
                            <div class="text-left">
                                <a href="#" class="theme-btn bg-trans border_btnlight">Explore secure deployment practices</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sec-tab-panel" id="secPanel1">
                    <div class="sec-panel-inner">
                        <div class="sec-panel-image">
                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
                                alt="Role-based access control">
                        </div>
                        <div class="sec-panel-text">
                            <h4>Granular user access control built for large Teams</h4>
                            <p>Assign permissions based on roles, departments, or security zones. i2V’s flexible access control
                                ensures the right people see the right information — nothing more, nothing less.</p>
                            <div class="text-left">
                                <a href="#" class="theme-btn bg-trans border_btnlight">View access control demo</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sec-tab-panel" id="secPanel2">
                    <div class="sec-panel-inner">
                        <div class="sec-panel-image">
                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
                                alt="Tamper-proof audit logs">
                        </div>
                        <div class="sec-panel-text">
                            <h4>Audit-ready logs that leave no action untracked</h4>
                            <p>Every critical system event, configuration change, and user interaction is logged and protected —
                                ensuring full traceability and compliance readiness across operations.</p>
                            <div class="text-left">
                                <a href="#" class="theme-btn bg-trans border_btnlight">Download audit & compliance guide</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sec-tab-panel" id="secPanel3">
                    <div class="sec-panel-inner">
                        <div class="sec-panel-image">
                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
                                alt="Offline mode support">
                        </div>
                        <div class="sec-panel-text">
                            <h4>Designed for secure, air-gapped deployments</h4>
                            <p>In environments where connectivity is restricted or internet use is prohibited, i2V still
                                delivers complete functionality — with no compromise on reliability or control.</p>
                            <div class="text-left">
                                <a href="#" class="theme-btn bg-trans border_btnlight">Request deployment consultation</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sec-tab-panel" id="secPanel4">
                    <div class="sec-panel-inner">
                        <div class="sec-panel-image">
                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
                                alt="Regular updates">
                        </div>
                        <div class="sec-panel-text">
                            <h4>Proactive security updates that keep you protected</h4>
                            <p>Our engineering team regularly releases updates focused on security hardening, aligned with
                                global standards and threat intelligence — so your system is always current and secure.</p>
                            <div class="text-left">
                                <a href="#" class="theme-btn bg-trans border_btnlight">Check our security update policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Simple Tab Switching for Security Tabs
                var secTabs = document.querySelectorAll('.sec-tab-item');
                var secPanels = document.querySelectorAll('.sec-tab-panel');
                var secSelectBrand = document.querySelector('.sec-select-brand');
                var secTabsList = document.querySelector('.sec-tabs-list');

                secTabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        var targetId = this.getAttribute('data-target');
                        var tabText = this.querySelector('.sec-tab-text') ? this.querySelector('.sec-tab-text').textContent.trim() : '';

                        // Remove active class from all tabs
                        secTabs.forEach(function (t) {
                            t.classList.remove('active');
                        });

                        // Remove active class from all panels
                        secPanels.forEach(function (p) {
                            p.classList.remove('active');
                        });

                        // Add active class to clicked tab
                        this.classList.add('active');

                        // Add active class to target panel
                        var targetPanel = document.getElementById(targetId);
                        if (targetPanel) {
                            targetPanel.classList.add('active');
                        }

                        // Update select-brand text on mobile
                        if (window.innerWidth <= 1024 && secSelectBrand && tabText) {
                            secSelectBrand.textContent = tabText;
                        }

                        // Close dropdown on mobile after selection
                        if (window.innerWidth <= 1024 && secSelectBrand && secTabsList) {
                            secSelectBrand.classList.remove('angle-icon');
                            secTabsList.classList.remove('show-dropdown');
                        }
                    });
                });

                // Mobile dropdown functionality
                if (secSelectBrand && secTabsList) {
                    secSelectBrand.addEventListener('click', function () {
                        if (window.innerWidth <= 1024) {
                            this.classList.toggle('angle-icon');
                            secTabsList.classList.toggle('show-dropdown');
                        }
                    });
                }
            });
        </script>
        <?php
    }
}
