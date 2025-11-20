<?php

namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PesananPaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $pesanan;
    public $type;

    public function __construct(Pesanan $pesanan, $type = 'pending')
    {
        $this->pesanan = $pesanan;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Prepare all data sebelum pass ke view
        $subject = $this->getSubject();
        $messageText = $this->getMessage();
        $statusText = $this->getStatusText();
        $paymentStatusText = $this->getPaymentStatusText();
        $actionUrl = $this->getActionUrl();
        $buttonText = $this->getButtonText();
        $footerText = $this->getFooter();

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.pesanan.modern', [
                'subject' => $subject,
                'pesanan' => $this->pesanan,
                'message' => $messageText,
                'statusText' => $statusText,
                'paymentStatusText' => $paymentStatusText,
                'actionUrl' => $actionUrl,
                'buttonText' => $buttonText,
                'footer' => $footerText,
            ]);
    }

    private function getSubject()
    {
        $subjects = [
            'success' => '✅ Pembayaran Berhasil - ' . $this->pesanan->order_id,
            'pending' => '🆕 Pesanan Baru Dibuat - ' . $this->pesanan->order_id,
            'failed' => '❌ Pembayaran Gagal - ' . $this->pesanan->order_id,
            'reminder' => '⏰ Pengingat Pembayaran - ' . $this->pesanan->order_id,
            'confirmed' => '✅ Pesanan Dikonfirmasi - ' . $this->pesanan->order_id,
        ];

        return $subjects[$this->type] ?? '📦 Notifikasi Pesanan - ' . $this->pesanan->order_id;
    }

    private function getMessage()
    {
        $messages = [
            'success' => 'Pembayaran untuk pesanan Anda telah berhasil diproses. Pesanan sedang dalam proses pengerjaan.',
            'pending' => 'Pesanan laundry Anda telah berhasil dibuat dan sedang menunggu konfirmasi dari tim kami.',
            'failed' => 'Maaf, proses pembayaran untuk pesanan Anda mengalami kendala. Silakan coba lagi.',
            'reminder' => 'Jangan lupa untuk menyelesaikan pembayaran pesanan laundry Anda.',
            'confirmed' => 'Pesanan laundry Anda telah dikonfirmasi dan sedang dipersiapkan oleh tim kami.',
        ];

        return $messages[$this->type] ?? 'Status pesanan laundry Anda telah diperbarui.';
    }

    private function getStatusText()
    {
        $statuses = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $statuses[$this->pesanan->status] ?? $this->pesanan->status;
    }

    private function getPaymentStatusText()
    {
        $statuses = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'expired' => 'Kadaluarsa',
        ];

        return $statuses[$this->pesanan->status_pembayaran] ?? $this->pesanan->status_pembayaran;
    }

    private function getActionUrl()
    {
        if ($this->pesanan->invoice_url) {
            return $this->pesanan->invoice_url;
        }

        return url('/pesanan/' . $this->pesanan->id);
    }

    private function getButtonText()
    {
        $texts = [
            'success' => 'Lihat Detail Pesanan',
            'pending' => 'Lihat Pesanan',
            'failed' => 'Coba Bayar Lagi',
            'reminder' => 'Bayar Sekarang',
            'confirmed' => 'Lihat Status',
        ];

        return $texts[$this->type] ?? 'Lihat Detail';
    }

    private function getFooter()
    {
        $footers = [
            'success' => 'Tim laundry kami akan segera memproses pesanan Anda. Anda akan mendapatkan notifikasi ketika pesanan sudah siap.',
            'pending' => 'Kami akan mengkonfirmasi pesanan Anda dalam 1x24 jam. Terima kasih atas kesabaran Anda.',
            'failed' => 'Jika mengalami kesulitan dalam pembayaran, silakan hubungi customer service kami untuk bantuan.',
            'reminder' => 'Pesanan akan otomatis dibatalkan jika pembayaran tidak dilakukan dalam waktu 24 jam.',
            'confirmed' => 'Estimasi waktu penyelesaian: 2-3 hari kerja. Kami akan mengirim update progres via email.',
        ];

        return $footers[$this->type] ?? 'Terima kasih telah menggunakan jasa laundry kami.';
    }

    public function toArray($notifiable)
    {
        return [
            'pesanan_id' => $this->pesanan->id,
            'order_id' => $this->pesanan->order_id,
            'type' => $this->type,
            'jumlah' => $this->pesanan->jumlah,
            'total_harga' => $this->pesanan->total_harga,
            'layanan' => $this->pesanan->layanan,
            'message' => $this->getMessage(),
            'action_url' => $this->getActionUrl(),
            'timestamp' => now(),
        ];
    }
}