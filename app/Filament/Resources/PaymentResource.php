<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    
    protected static ?string $navigationGroup = 'Ticket Management';

    protected static ?string $navigationLabel = 'Payments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\Select::make('booking_id')
                            ->label('Booking')
                            ->relationship('booking', 'booking_code')
                            ->required()
                            ->searchable(),
                            
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('order_id')
                            ->label('Order ID')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Method')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Payment Status')
                            ->options([
                                'pending' => 'Pending',
                                'settlement' => 'Settlement',
                                'challenge' => 'Challenge',
                                'expire' => 'Expire',
                                'cancel' => 'Cancel',
                                'deny' => 'Deny',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Payment Method'),
                            
                        Forms\Components\TextInput::make('midtrans_transaction_id')
                            ->label('Midtrans Transaction ID')
                            ->disabled(),
                            
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Paid At'),
                    ])->columns(2),

                Forms\Components\Section::make('Midtrans Response')
                    ->schema([
                        Forms\Components\Textarea::make('midtrans_response')
                            ->label('Raw Response')
                            ->rows(5)
                            ->disabled()
                            ->formatStateUsing(function ($state) {
                                return is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state;
                            }),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.booking_code')
                    ->label('Booking Code')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('booking.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Order ID')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'settlement',
                        'info' => 'challenge',
                        'danger' => ['expire', 'cancel', 'deny'],
                    ]),
                    
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Paid At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'settlement' => 'Settlement',
                        'challenge' => 'Challenge',
                        'expire' => 'Expire',
                        'cancel' => 'Cancel',
                        'deny' => 'Deny',
                    ]),
                    
                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'credit_card' => 'Credit Card',
                        'echannel' => 'E-Channel',
                        'gopay' => 'GoPay',
                        'shopeepay' => 'ShopeePay',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view' => Pages\ViewPayment::route('/{record}'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}