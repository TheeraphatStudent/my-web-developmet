<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');

class AlertRef extends Component
{
  private string $icon;
  private string $title;
  private string $text;

  public function __construct(string $icon = 'warning', string $title = 'Alert', string $text = 'Something went wrong!')
  {
    $this->icon = $icon;
    $this->title = $title;
    $this->text = $text;
  }

  public function render()
  {
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: '<?= addslashes($this->title) ?>',
          text: '<?= addslashes($this->text) ?>',
          icon: '<?= $this->icon ?>',
          showCancelButton: true,
          confirmButtonText: 'ตกลง',
          cancelButtonText: 'ยกเลิก'
        });
      });
    </script>
<?php
  }
}

class NotLoggedIn extends AlertRef
{
  public function __construct()
  {
    parent::__construct(
      icon: 'warning',
      title: 'คุณยังไม่ได้เข้าสู่ระบบ',
      text: "หากต้องการสร้างหรือเข้าร่วมกิจกรรม\nต้องเข้าสู่ระบบก่อน"
    );
  }
}
?>