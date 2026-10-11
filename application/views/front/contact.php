<div class="container" style="padding-bottom:90px">
  <div class="page-head"><span class="eyebrow">We are here to help</span><h1>Contact us</h1><p>Questions about an order, sizing or a custom request? Send us a note and we will reply within one working day.</p></div>
  <div class="row g-5">
    <div class="col-lg-7"><form class="panel-d" method="post" action="<?= site_url('pages/send_contact') ?>"><?= csrf_field() ?><div class="row g-3">
      <div class="col-md-6"><label class="lbl">Name *</label><input class="input-d" name="name" required value="<?= $customer ? e($customer->name) : '' ?>"></div>
      <div class="col-md-6"><label class="lbl">Email *</label><input class="input-d" type="email" name="email" required value="<?= $customer ? e($customer->email) : '' ?>"></div>
      <div class="col-12"><label class="lbl">Subject</label><input class="input-d" name="subject"></div>
      <div class="col-12"><label class="lbl">Message *</label><textarea class="input-d" name="message" required minlength="10"></textarea></div>
    </div><button class="btn-d mt-4">Send message</button></form></div>
    <div class="col-lg-5"><div class="panel-d">
      <div class="d-flex gap-3 mb-4"><?= icon('phone', 22) ?><div><b>Phone / WhatsApp</b><div style="color:var(--mute)"><?= e(setting('contact_phone')) ?></div></div></div>
      <div class="d-flex gap-3 mb-4"><?= icon('mail', 22) ?><div><b>Email</b><div style="color:var(--mute)"><?= e(setting('contact_email')) ?></div></div></div>
      <div class="d-flex gap-3 mb-4"><?= icon('map-pin', 22) ?><div><b>Studio</b><div style="color:var(--mute)"><?= e(setting('contact_address')) ?></div></div></div>
      <div class="d-flex gap-3"><?= icon('clock', 22) ?><div><b>Hours</b><div style="color:var(--mute)"><?= e(setting('contact_hours', 'Mon - Sat, 10am - 8pm')) ?></div></div></div>
    </div>
    <div class="panel-d mt-4 connect">
      <h5 style="margin-bottom:14px">Chat with us</h5>
      <?php $nets = array('whatsapp' => array('WhatsApp', 'Chat now', ''), 'facebook' => array('Facebook', 'Message us', 'Visit page'), 'instagram' => array('Instagram', 'Message us', 'View profile'));
      foreach ($nets as $k => $n): list($page, $chat) = social_link($k); if (!$page) continue; ?>
      <div class="conn-row">
        <span class="conn-ic conn-<?= $k ?>"><?= brand_icon($k, 20) ?></span>
        <div class="conn-t"><b><?= $n[0] ?></b></div>
        <div class="conn-a">
          <a class="btn-d btn-sm" href="<?= e($chat) ?>" target="_blank" rel="noopener"><?= $n[1] ?></a>
          <?php if ($n[2] && $page !== $chat): ?><a class="btn-o btn-sm" href="<?= e($page) ?>" target="_blank" rel="noopener"><?= $n[2] ?></a><?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div></div>
  </div>
</div>
