<x-action-section>
    <x-slot name="title">
        {{ __('التحقق بخطوتين') }}
    </x-slot>

    <x-slot name="description">
        {{ __('أضف طبقة أمان إضافية إلى حسابك باستخدام التحقق بخطوتين') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('أكمل تفعيل التحقق بخطوتين') }}
                @else
                    {{ __('لقد قمت بتفعيل التحقق بخطوتين') }}
                @endif
            @else
                {{ __('لم تقم بتفعيل التحقق بخطوتين بعد') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('عند تفعيل التحقق بخطوتين، سيُطلب منك إدخال رمز أمان عشوائي أثناء عملية التحقق. يمكنك الحصول على هذا الرمز من تطبيق Google Authenticator على هاتفك') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('لإنهاء تفعيل التحقق بخطوتين، قم بمسح رمز الاستجابة السريعة (QR) التالي باستخدام تطبيق المصادقة على هاتفك أو أدخل مفتاح الإعداد، ثم قدم رمز التحقق (OTP) المُولد.') }}
                        @else
                            {{ __('تم تفعيل التحقق بخطوتين الآن. قم بمسح رمز الاستجابة السريعة (QR) التالي باستخدام تطبيق المصادقة على هاتفك أو أدخل مفتاح الإعداد.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('مفتاح الإعداد') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('الرمز') }}" />

                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('احتفظ بهذه الرموز الاحتياطية في مدير كلمات مرور آمن. يمكن استخدامها لاستعادة الوصول إلى حسابك إذا فقدت جهاز التحقق بخطوتين') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ __('تفعيل') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('إعادة توليد رموز الاسترداد') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="me-3" wire:loading.attr="disabled">
                            {{ __('تأكيد') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('عرض رموز الاسترداد') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled">
                            {{ __('إلغاء') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            {{ __('تعطيل') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section>
