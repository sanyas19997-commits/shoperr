<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            // open  — user is waiting for a reply
            // answered — admin replied, user has not responded yet
            // pending — user responded to the admin, admin turn again
            // closed — either side closed the thread
            $table->string('status', 16)->default('open');
            $table->timestamp('last_message_at')->nullable();
            $table->unsignedInteger('user_unread')->default(0);
            $table->unsignedInteger('admin_unread')->default(0);
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index('last_message_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
