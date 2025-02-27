<html>

<head></head>

<body>
    <header>
        <h1>ระบบลงทะเบียนเรียน</h1>
    </header>
    <nav>
        <a href="/">หน้าแรก</a>
        <?php
        if (isset($_SESSION['timestamp'])) {
        ?>
            <a href="/profile">ข้อมูลนักเรียน</a>
            <a href="/courses">รายวิชา</a>
            <a href="/logout">ออกจากระบบ</a>
        <?php
        } else {
        ?>
            <a href="/login">เข้าสู่ระบบ</a>
        <?php
        }
        ?>
    </nav>