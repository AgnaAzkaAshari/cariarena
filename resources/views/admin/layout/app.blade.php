<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - @yield('title', 'CariArena')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #63B3ED;
            --primary-hover: #90CDF4;
            --primary-light: #EBF8FF;
            --text-dark: #1A202C;
            --text-light: #718096;
            --bg-light: #EDF2F7;
            --card-bg: #FFFFFF;
            --success: #48BB78;
            --warning: #ECC94B;
            --danger: #F56565;
            --sidebar-bg: #FFFFFF;
        }

        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            display: flex;
            margin: 0;
            padding: 0;
        }

        /* ==== SIDEBAR ==== */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--text-light);
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .sidebar .logo i {
            font-size: 28px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .sidebar h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: var(--text-dark);
        }

        .sidebar hr {
            border-color: rgba(113, 128, 150, 0.2);
            margin: 20px 0;
        }

        .sidebar .nav-title {
            font-size: 12px;
            letter-spacing: 1px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .sidebar .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar .nav-menu li {
            margin-bottom: 8px;
        }

        .sidebar .nav-menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar .nav-menu a i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-menu a:hover {
            background: var(--primary-light);
            color: var(--text-dark);
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(99, 179, 237, 0.1);
        }

        .sidebar .nav-menu a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 179, 237, 0.2);
            transform: translateX(0);
        }

        /* Animasi shimmer untuk menu aktif */
        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(30deg);
            }
            100% {
                transform: translateX(100%) translateY(100%) rotate(30deg);
            }
        }

        /* Garis indikator untuk menu aktif */
        .sidebar .nav-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        /* Efek kilat pada menu aktif */
        .sidebar .nav-menu a.active::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            animation: shimmer 3s infinite;
        }

        /* Saat menu aktif, ikon berubah menjadi putih */
        .sidebar .nav-menu a.active i {
            color: white !important;
        }

        /* ==== WARNA IKON UNTUK SETIAP MENU ==== */
        .sidebar .nav-menu a .fa-tachometer-alt {color: #4C8BF5;}
        .sidebar .nav-menu a .fa-users {color: #22C55E;}
        .sidebar .nav-menu a .fa-store {color: #F59E0B;}
        .sidebar .nav-menu a .fa-calendar-alt {color: #EC4899;}
        .sidebar .nav-menu a .fa-credit-card {color: #8B5CF6;}
        .sidebar .nav-menu a .fa-chart-bar {color: #F87171;}
        .sidebar .nav-menu a .fa-cog {color: #94A3B8;}
        
        /* Menu logout dengan warna merah */
        .sidebar .nav-menu .logout-btn {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: #F56565;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        
        .sidebar .nav-menu .logout-btn:hover {
            background: #FED7D7;
            color: #C53030;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(245, 101, 101, 0.1);
        }
        
        .sidebar .nav-menu .logout-btn i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
            color: #F56565;
        }
        
        .sidebar .nav-menu .logout-btn:hover i {
            color: #C53030;
        }

        /* ==== MAIN CONTENT ==== */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            flex: 1;
            background-color: var(--bg-light);
            min-height: 100vh;
            transition: all 0.3s ease;
            width: calc(100% - 260px);
        }

        /* Header */
        .topbar {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(45, 55, 72, 0.1);
            margin-bottom: 1.5rem;
            border-left: 5px solid var(--primary-color);
        }

        .topbar h1 {
            color: var(--primary-color);
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }

        /* ==== CARD STATS ==== */
        .stat-card {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            position: relative;
            border: none;
            transition: transform 0.3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        /* Border left warna-warni untuk setiap card */
        .stat-card:nth-child(1) { border-left: 4px solid #4299E1; }
        .stat-card:nth-child(2) { border-left: 4px solid #48BB78; }
        .stat-card:nth-child(3) { border-left: 4px solid #ED8936; }
        .stat-card:nth-child(4) { border-left: 4px solid #9F7AEA; }

        /* ==== CONTENT SECTIONS ==== */
        .dashboard-section {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .dashboard-section:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .section-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 0 0 15px 0;
            margin-bottom: 15px;
            flex-shrink: 0;
        }

        .section-header h5 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: var(--primary-color);
        }

        .section-body {
            padding: 0;
            flex: 1;
        }

        .booking-item, .venue-item, .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s;
        }

        .booking-item:hover, .venue-item:hover, .notification-item:hover {
            background-color: #F9FAFB;
        }

        .booking-item:last-child, .venue-item:last-child, .notification-item:last-child {
            border-bottom: none;
        }

        .booking-info strong {
            font-size: 14px;
            display: block;
            margin-bottom: 4px;
        }

        .booking-info p {
            font-size: 13px;
            color: var(--text-light);
            margin: 0;
        }

        .status {
            font-size: 12px;
            border-radius: 6px;
            padding: 3px 8px;
            font-weight: 500;
            display: inline-block;
            margin-top: 5px;
        }

        .confirmed {
            background: #C6F6D5;
            color: var(--success);
        }

        .pending {
            background: #FEFCBF;
            color: var(--warning);
        }

        /* ==== NOTIFIKASI ==== */
        .notification-small .notification-item {
            padding: 8px 0;
        }

        .notification-small .notification-item h6 {
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .notification-small .notification-item p {
            font-size: 0.8rem;
            margin-bottom: 2px;
        }

        .notification-small .notification-item small {
            font-size: 0.7rem;
        }

        /* ==== BUTTONS ==== */
        .btn-action {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            border: 1px solid #E5E7EB;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 179, 237, 0.3);
            background: var(--primary-hover);
            color: white;
        }

        .stat-item {
            padding: 12px 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-value {
            font-size: 1.125rem;
            font-weight: 700;
        }

        .change-positive {
            color: var(--success);
        }

        .change-negative {
            color: var(--danger);
        }

        /* ==== LAYOUT PERBAIKAN ==== */
        .equal-height-row {
            display: flex;
            flex-wrap: wrap;
        }

        .equal-height-row > [class*="col-"] {
            display: flex;
            flex-direction: column;
        }

        .main-content-section {
            margin-bottom: 24px;
        }

        /* ==== STYLE TOMBOL LIHAT SEMUA ==== */
        .lihat-semua-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .lihat-semua-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 179, 237, 0.3);
            color: white;
            text-decoration: none;
        }

        .lihat-semua-btn i {
            margin-left: 5px;
            font-size: 0.8rem;
        }

        /* ==== MOBILE NAVIGATION ==== */
        .mobile-nav {
            display: none;
            background: white;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(45, 55, 72, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .mobile-nav .logo {
            display: flex;
            align-items: center;
        }

        .mobile-nav .logo i {
            font-size: 24px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .mobile-nav h2 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: var(--text-dark);
        }

        .mobile-menu-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        /* ==== OVERLAY UNTUK MOBILE ==== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* ==== DIVIDER UNTUK LOGOUT ==== */
        .sidebar .nav-divider {
            margin: 20px 0;
            border-color: rgba(113, 128, 150, 0.2);
        }

        /* ==== MODAL KONFIRMASI LOGOUT ==== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1100;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .logout-modal {
            background: white;
            border-radius: 14px;
            padding: 25px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-modal .modal-icon {
            font-size: 3rem;
            color: #F56565;
            margin-bottom: 15px;
        }

        .logout-modal h4 {
            color: var(--text-dark);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .logout-modal p {
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .modal-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            flex: 1;
        }

        .modal-btn-cancel {
            background: #EDF2F7;
            color: var(--text-dark);
        }

        .modal-btn-cancel:hover {
            background: #E2E8F0;
        }

        .modal-btn-confirm {
            background: #F56565;
            color: white;
        }

        .modal-btn-confirm:hover {
            background: #E53E3E;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
        }

        /* ==== RESPONSIVE BREAKPOINTS ==== */
        @media (max-width: 1200px) {
            .main-content {
                padding: 25px;
            }
        }

        @media (max-width: 992px) {
            .main-content {
                padding: 20px;
            }
            
            .stat-card h3 {
                font-size: 1.5rem;
            }
            
            .topbar h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
                width: 100%;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .mobile-nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .topbar {
                margin-top: 1rem;
                padding: 0.75rem 1rem;
                margin-bottom: 1rem;
            }
            
            .topbar h1 {
                font-size: 20px;
            }
            
            .stat-card {
                padding: 15px;
                margin-bottom: 15px;
            }
            
            .stat-card h3 {
                font-size: 1.4rem;
            }
            
            .dashboard-section {
                padding: 15px;
            }
            
            .section-header h5 {
                font-size: 15px;
            }
            
            .booking-item, .venue-item, .notification-item {
                padding: 10px 0;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .booking-item > div:last-child, 
            .venue-item > div:last-child {
                margin-top: 8px;
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .booking-info strong, .venue-item strong {
                font-size: 13px;
            }
            
            .booking-info p, .venue-item p {
                font-size: 12px;
            }
            
            .lihat-semua-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .notification-item h6 {
                font-size: 0.85rem;
            }
            
            .notification-item p {
                font-size: 0.75rem;
            }
            
            .notification-item small {
                font-size: 0.65rem;
            }
            
            .stat-item {
                padding: 10px 0;
            }
            
            .stat-value {
                font-size: 1rem;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .mobile-nav {
                padding: 0.75rem;
            }
            
            .topbar {
                padding: 0.5rem 0.75rem;
                border-radius: 8px;
            }
            
            .topbar h1 {
                font-size: 18px;
            }
            
            .stat-card {
                padding: 12px;
                border-radius: 10px;
            }
            
            .stat-card h3 {
                font-size: 1.3rem;
            }
            
            .dashboard-section {
                padding: 12px;
                border-radius: 10px;
            }
            
            .section-header {
                padding-bottom: 10px;
                margin-bottom: 10px;
            }
            
            .section-header h5 {
                font-size: 14px;
            }
            
            .booking-item, .venue-item, .notification-item {
                padding: 8px 0;
            }
            
            .booking-item > div:last-child, 
            .venue-item > div:last-child {
                margin-top: 6px;
            }
            
            .status {
                font-size: 11px;
                padding: 2px 6px;
            }
            
            .lihat-semua-btn {
                padding: 5px 10px;
                font-size: 0.75rem;
            }
            
            .notification-item {
                padding: 6px 0;
            }
            
            .notification-item h6 {
                font-size: 0.8rem;
            }
            
            .notification-item p {
                font-size: 0.7rem;
            }
            
            .notification-item small {
                font-size: 0.6rem;
            }
            
            .stat-item {
                padding: 8px 0;
            }
            
            .stat-value {
                font-size: 0.9rem;
            }
            
            .modal-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 400px) {
            .main-content {
                padding: 8px;
            }
            
            .mobile-nav {
                padding: 0.5rem;
            }
            
            .topbar {
                padding: 0.5rem;
            }
            
            .topbar h1 {
                font-size: 16px;
            }
            
            .stat-card {
                padding: 10px;
            }
            
            .stat-card h3 {
                font-size: 1.2rem;
            }
            
            .dashboard-section {
                padding: 10px;
            }
        }

        /* ==== IMPROVED RESPONSIVE STYLES ==== */
        @media (max-width: 1200px) {
            .sidebar {
                width: 240px;
            }
            
            .main-content {
                margin-left: 240px;
                width: calc(100% - 240px);
            }
            
            .topbar h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
                padding: 20px 15px;
            }
            
            .main-content {
                margin-left: 220px;
                width: calc(100% - 220px);
                padding: 20px;
            }
            
            .sidebar h2 {
                font-size: 18px;
            }
            
            .sidebar .nav-menu a {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            
            .topbar h1 {
                font-size: 22px;
            }
            
            .stat-card h3 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .mobile-nav {
                display: flex;
            }
            
            .topbar {
                margin-top: 1rem;
                padding: 1rem;
            }
            
            .topbar h1 {
                font-size: 20px;
            }
            
            .navbar .container-fluid {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .navbar .d-flex {
                margin-top: 0.5rem;
                width: 100%;
                justify-content: space-between;
            }
            
            .sidebar .nav-menu a:hover {
                transform: none;
            }
            
            .sidebar .nav-menu .logout-btn:hover {
                background: #FED7D7;
                color: #C53030;
                transform: translateX(3px);
                box-shadow: 0 2px 8px rgba(245, 101, 101, 0.1);
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .mobile-nav {
                padding: 0.75rem;
            }
            
            .mobile-nav h2 {
                font-size: 16px;
            }
            
            .topbar {
                padding: 0.75rem;
                margin-bottom: 1rem;
            }
            
            .topbar h1 {
                font-size: 18px;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .sidebar .logo {
                justify-content: center;
                text-align: center;
            }
            
            .sidebar .nav-menu a {
                justify-content: center;
                padding: 12px 15px;
            }
            
            .sidebar .nav-menu a i {
                margin-right: 15px;
            }
            
            .navbar .d-flex .text-muted {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .main-content {
                padding: 8px;
            }
            
            .mobile-nav {
                padding: 0.5rem;
            }
            
            .mobile-nav h2 {
                font-size: 14px;
            }
            
            .topbar {
                padding: 0.5rem;
            }
            
            .topbar h1 {
                font-size: 16px;
            }
            
            .sidebar .nav-menu a {
                font-size: 0.85rem;
                padding: 10px 12px;
            }
            
            .sidebar .nav-title {
                text-align: center;
            }
        }

        /* Improved mobile navigation */
        .mobile-nav {
            display: none;
            background: white;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(45, 55, 72, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-menu-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-dark);
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .mobile-menu-toggle:hover {
            background-color: var(--bg-light);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Improved responsive behavior for main content */
        @media (max-width: 768px) {
            .equal-height-row > [class*="col-"] {
                display: block;
            }
            
            .dashboard-section {
                min-height: auto !important;
                margin-bottom: 1rem;
            }
        }

        /* ==== PERBAIKAN UNTUK TOPBAR NAVBAR ==== */
        .navbar.topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(45, 55, 72, 0.1);
            margin-bottom: 1.5rem;
            border-left: 5px solid var(--primary-color);
        }

        .navbar.topbar .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0;
        }

        .navbar.topbar .btn {
            padding: 0.5rem;
            margin-right: 1rem;
        }

        .navbar.topbar h1 {
            margin: 0;
            flex: 1;
        }

        .navbar.topbar .d-flex {
            display: flex;
            align-items: center;
        }

        /* ==== PERBAIKAN UNTUK SCROLLBAR ==== */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <div class="logo">
            <i class="fas fa-volleyball-ball"></i>
            <h2>CariArena</h2>
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-volleyball-ball"></i>
            <h2>CariArena</h2>
        </div>
        <hr>
        <div class="nav-title">NAVIGATION</div>
        <ul class="nav-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Manajemen Pengguna</a></li>
            <li><a href="{{ route('admin.venue.index') }}" class="{{ request()->routeIs('admin.venue.*') ? 'active' : '' }}"><i class="fas fa-store"></i> Manajemen Venue</a></li>
            <li><a href="{{ route('admin.pemesanan.index') }}" class="{{ request()->routeIs('admin.pemesanan.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Manajemen Pemesanan</a></li>
            <li><a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Transaksi</a></li>
            <li><a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Laporan</a></li>
            <li><a href="{{ route('admin.pengaturan.index') }}" class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}"><i class="fas fa-cog"></i> Pengaturan</a></li>
        </ul>
        
        <!-- Divider untuk logout -->
        <hr class="nav-divider">
        
        <!-- Tombol Logout -->
        <ul class="nav-menu">
            <li>
                <button class="logout-btn" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </li>
        </ul>
    </aside>

    <div class="sidebar-overlay"></div>

    <div class="main-content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand topbar mb-4 static-top">
            <div class="container-fluid">
                <button class="btn btn-link d-lg-none" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h1 class="h3 mb-0">@yield('page-title', 'Dashboard')</h1>
                
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3 d-none d-sm-inline">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal-overlay" id="logoutModal">
        <div class="logout-modal">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h4>Konfirmasi Logout</h4>
            <p>Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" id="cancelLogout">Batal</button>
                <form action="{{ route('admin.logout') }}" method="POST" id="logoutForm" style="display: none;">
                    @csrf
                </form>
                <button class="modal-btn modal-btn-confirm" id="confirmLogout">Logout</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar untuk mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        // Close sidebar ketika overlay diklik
        document.querySelector('.sidebar-overlay').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Animasi untuk menu sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.sidebar .nav-menu a');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Tutup sidebar di mobile setelah memilih menu
                    if (window.innerWidth <= 768) {
                        const sidebar = document.querySelector('.sidebar');
                        const overlay = document.querySelector('.sidebar-overlay');
                        
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });

            // Logout functionality
            const logoutBtn = document.getElementById('logoutBtn');
            const logoutModal = document.getElementById('logoutModal');
            const cancelLogout = document.getElementById('cancelLogout');
            const confirmLogout = document.getElementById('confirmLogout');
            const logoutForm = document.getElementById('logoutForm');

            // Tampilkan modal konfirmasi logout
            logoutBtn.addEventListener('click', function() {
                logoutModal.classList.add('active');
                
                // Tutup sidebar di mobile saat logout diklik
                if (window.innerWidth <= 768) {
                    const sidebar = document.querySelector('.sidebar');
                    const overlay = document.querySelector('.sidebar-overlay');
                    
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });

            // Tutup modal ketika batal diklik
            cancelLogout.addEventListener('click', function() {
                logoutModal.classList.remove('active');
            });

            // Proses logout ketika konfirmasi diklik
            confirmLogout.addEventListener('click', function() {
                // Submit form logout
                if (logoutForm) {
                    logoutForm.submit();
                } else {
                    // Fallback jika form tidak ada
                    window.location.href = "{{ route('admin.logout') }}";
                }
            });

            // Tutup modal ketika klik di luar modal
            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) {
                    logoutModal.classList.remove('active');
                }
            });

            // Set equal height for sections
            function setEqualHeights() {
                const leftSections = document.querySelectorAll('.col-xl-8 .dashboard-section');
                const rightSections = document.querySelectorAll('.col-xl-4 .dashboard-section');
                
                // Reset heights first
                [...leftSections, ...rightSections].forEach(section => {
                    section.style.minHeight = 'auto';
                });
                
                // Calculate max height for each row
                const leftHeight = Math.max(...Array.from(leftSections).map(s => s.offsetHeight));
                const rightHeight = Math.max(...Array.from(rightSections).map(s => s.offsetHeight));
                
                // Set equal heights
                leftSections.forEach(section => {
                    section.style.minHeight = leftHeight + 'px';
                });
                
                rightSections.forEach(section => {
                    section.style.minHeight = rightHeight + 'px';
                });
            }

            // Set equal heights on load and resize
            window.addEventListener('load', setEqualHeights);
            window.addEventListener('resize', setEqualHeights);
        });
    </script>
    
    @stack('scripts')
</body>
</html>