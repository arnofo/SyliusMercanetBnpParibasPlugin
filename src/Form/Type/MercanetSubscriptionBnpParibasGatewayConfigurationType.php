<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\MercanetBnpParibasPlugin\Form\Type;

use BitBag\MercanetBnpParibasPlugin\Legacy\Mercanet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class MercanetSubscriptionBnpParibasGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('environment', ChoiceType::class, [
                'choices' => [
                    'bitbag.mercanet_bnp_paribas.production' => Mercanet::PRODUCTION,
                    'bitbag.mercanet_bnp_paribas.test' => Mercanet::TEST,
                    'bitbag.mercanet_bnp_paribas.simulation' => Mercanet::SIMULATION,
                ],
                'label' => 'bitbag.mercanet_bnp_paribas.environment',
            ])
            ->add('secret_key', TextType::class, [
                'label' => 'bitbag.mercanet_bnp_paribas.secure_key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag.mercanet_bnp_paribas.secure_key.not_blank',
                        'groups' => ['sylius']
                    ])
                ],
            ])
            ->add('merchant_id', TextType::class, [
                'label' => 'bitbag.mercanet_bnp_paribas.merchant_id',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag.mercanet_bnp_paribas.merchant_id.not_blank',
                        'groups' => ['sylius']
                    ])
                ],
            ])
            ->add('key_version', TextType::class, [
                'label' => 'bitbag.mercanet_bnp_paribas.key_version',
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag.mercanet_bnp_paribas.key_version.not_blank',
                        'groups' => ['sylius']
                    ])
                ],
            ])
            ->add('times', NumberType::class, [
                'label' => 'bitbag.mercanet_bnp_paribas.times',
                'required' => false,
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'minMessage' => 'bitbag.mercanet_bnp_paribas.times.min_range',
                        'groups' => ['sylius'],
                    ]),
                ],
            ])
            ->add('interval', DateIntervalType::class, [
                'label' => 'bitbag.mercanet_bnp_paribas.interval',
                'with_years' => true,
                'with_months' => true,
                'with_days' => true,
                'with_hours' => false,
                'input' => 'array',
                'labels' => [
                    'years' => 'bitbag.mercanet_bnp_paribas.years',
                    'months' => 'bitbag.mercanet_bnp_paribas.months',
                    'days' => 'bitbag.mercanet_bnp_paribas.days',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'bitbag.mercanet_bnp_paribas.interval.not_blank',
                        'groups' => ['sylius'],
                    ]),
                ]
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();
                $data['payum.http_client'] = '@bitbag.mercanet_bnp_paribas.bridge.mercanet_bnp_paribas_bridge';
                $event->setData($data);
            });
    }
}
