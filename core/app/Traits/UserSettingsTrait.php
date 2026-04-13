<?php

namespace App\Traits;

use App\Models\UserSetting;

trait UserSettingsTrait
{
    /**
     * Obtém uma configuração do usuário
     */
    public function getSetting(string $key, $default = null)
    {
        $setting = $this->settings()->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Define uma configuração do usuário
     */
    public function setSetting(string $key, $value): void
    {
        $this->settings()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Remove uma configuração do usuário
     */
    public function removeSetting(string $key): void
    {
        $this->settings()->where('key', $key)->delete();
    }

    /**
     * Obtém todas as configurações do usuário
     */
    public function getAllSettings(): array
    {
        return $this->settings()->pluck('value', 'key')->toArray();
    }

    /**
     * Relação com configurações do usuário
     */
    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }

    /**
     * Obtém dados bancários do usuário
     */
    public function getBankData(): array
    {
        $bank = $this->banks()->where('main', 1)->first();

        if (!$bank) {
            return [];
        }

        return [
            'bank_name' => $bank->name,
            'bank_code' => $bank->bank_code,
            'agency' => $bank->agency,
            'account_number' => $bank->account,
            'account_type' => $bank->type,
            'account_holder' => $bank->holder_name,
            'document' => $bank->document,
            'pix_key' => $bank->pix_key,
            'pix_key_type' => $bank->pix_key_type
        ];
    }

    /**
     * Obtém o ID do afiliado
     */
    public function getAffiliateIdAttribute()
    {
        return $this->getSetting('affiliate_id');
    }

    /**
     * Obtém o status de compliance
     */
    public function getComplianceStatusAttribute(): string
    {
        if ($this->kyc_status === 'approved') {
            return 'approved';
        }

        if ($this->kyc_status === 'pending') {
            return 'pending';
        }

        return 'not_submitted';
    }

    /**
     * Verifica se o usuário tem um tipo específico
     */
    public function isType(string $type): bool
    {
        return $this->user_type === $type;
    }

    /**
     * Obtém configuração de taxa personalizada
     */
    public function getCustomFee(string $paymentMethod, string $feeType = 'percentage')
    {
        return $this->getSetting("custom_fee_{$paymentMethod}_{$feeType}");
    }

    /**
     * Define configuração de taxa personalizada
     */
    public function setCustomFee(string $paymentMethod, string $feeType, $value): void
    {
        $this->setSetting("custom_fee_{$paymentMethod}_{$feeType}", $value);
    }
}