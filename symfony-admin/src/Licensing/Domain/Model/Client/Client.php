<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\Model\AggregateEventsTrait;
use App\Common\Domain\Model\EntityId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Client
{
    use AggregateEventsTrait;

    private EntityId $id;
    private string $name;
    private string $email;
    private string $description;
    private ClientStatusEnum $status;
    private LicenseTypeEnum $activeLicenseType;
    private EntityId $activeLicenseProductId;
    private int $activeLicenseVersion;
    private Collection $licenses;

    public static function create(
        EntityId $id,
        string $name,
        string $email,
        string $description,
        LicenseTypeEnum $licenseType,
        EntityId $productId,
    ): Client {
        $client = new Client();
        $client->applyEvent(new ClientWasCreated(0, $id->get(), $name, $email, $description, $licenseType->value, $productId->get()));
        return $client;
    }

    private function __construct()
    {
        $this->licenses = new ArrayCollection();
    }

    public static function fromSnapshot(array $data, int $playhead, array $events): self
    {
        $self = new self();
        $self->playhead = $playhead;
        $self->id = EntityId::fromString($data['id']);
        $self->name = $data['name'];
        $self->email = $data['email'];
        $self->description = $data['description'];
        $self->status = ClientStatusEnum::from($data['status']);
        $self->activeLicenseType = LicenseTypeEnum::from($data['activeLicenseType']);
        $self->activeLicenseProductId = EntityId::fromString($data['activeLicenseProductId']);
        $self->activeLicenseVersion = $data['activeLicenseVersion'];

        foreach ($data['licenses'] as $license) {
            $self->createLicense(
                $license['version'],
                LicenseTypeEnum::from($license['type']),
                EntityId::fromString($license['productId']),
            );
        }

        foreach ($events as $event) {
            $self->apply($event);
        }

        return $self;
    }

    public function toSnapshot(): array
    {
        $licenses = [];
        /** @var License $license */
        foreach ($this->licenses as $license) {
            $licenses[] = [
                'version' => $license->getVersion(),
                'type' => $license->getType()->value,
                'productId' => $license->getProductId()->get(),
            ];
        }
        return [
            'id' => $this->id->get(),
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'status' => $this->status->value,
            'activeLicenseType' => $this->activeLicenseType->value,
            'activeLicenseProductId' => $this->activeLicenseProductId->get(),
            'activeLicenseVersion' => $this->activeLicenseVersion,
            'licenses' => $licenses,
        ];
    }

    private function createLicense(int $version, LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $license = License::create($this, $version, $licenseType, $productId);
        $this->licenses->add($license);
    }

    public function changeLicense(LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $this->applyEvent(new ClientLicenseWasChanged(++$this->playhead, $this->id->get(), $licenseType->value, $productId->get()));
    }

    public function update(string $name, string $email, string $description): void
    {
        $this->applyEvent(new ClientWasUpdated(++$this->playhead, $this->id->get(), $name, $email, $description));
    }


    public function activate(): void
    {
        $this->applyEvent(new ClientWasActivated(++$this->playhead, $this->id->get()));
    }


    public function deactivate(): void
    {
        $this->applyEvent(new ClientWasDeactivated(++$this->playhead, $this->id->get()));
    }


    public function delete(): void
    {
        $this->applyEvent(new ClientWasDeleted(++$this->playhead, $this->id->get()));
    }

    private function applyClientWasCreated(ClientWasCreated $event): void
    {
        $this->id = EntityId::fromString($event->id);
        $this->name = $event->name;
        $this->email = $event->email;
        $this->description = $event->description;
        $this->activeLicenseType = LicenseTypeEnum::from($event->licenseType);
        $this->activeLicenseProductId = EntityId::fromString($event->productId);
        $this->activeLicenseVersion = 1;
        $this->createLicense($this->activeLicenseVersion, $this->activeLicenseType, $this->activeLicenseProductId);

        $this->status = ClientStatusEnum::ONBOARDING;
    }

    private function applyClientWasUpdated(ClientWasUpdated $event): void
    {
        $this->name = $event->name;
        $this->email = $event->email;
        $this->description = $event->description;
    }

    private function applyClientLicenseWasChanged(ClientLicenseWasChanged $event): void
    {
        $this->activeLicenseVersion++;
        $this->activeLicenseType = LicenseTypeEnum::from($event->licenseType);
        $this->activeLicenseProductId = EntityId::fromString($event->productId);
        $this->createLicense($this->activeLicenseVersion, $this->activeLicenseType, $this->activeLicenseProductId);
    }

    private function applyClientWasActivated(ClientWasActivated $clientWasActivated): void
    {
        $this->status = ClientStatusEnum::ACTIVE;
    }

    private function applyClientWasDeactivated(ClientWasDeactivated $clientWasDeactivated): void
    {
        $this->status = ClientStatusEnum::INACTIVE;
    }

    private function applyClientWasDeleted(ClientWasDeleted $clientWasDeactivated): void
    {
        $this->status = ClientStatusEnum::DELETED;
    }

    /**
     * @return LicenseLogItem[]
     */
    public function getLicensesLog(): array
    {
        $result = [];
        foreach ($this->licenses as $license) {
            $result[] = new LicenseLogItem($license->getDate(), $license->getVersion(), $license->getType(), $license->getProductId());
        }
        return $result;
    }

    public function getId(): EntityId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): ClientStatusEnum
    {
        return $this->status;
    }

    public function getActiveLicenseType(): LicenseTypeEnum
    {
        return $this->activeLicenseType;
    }

    public function getActiveLicenseProductId(): EntityId
    {
        return $this->activeLicenseProductId;
    }

    public function getActiveLicenseVersion(): int
    {
        return $this->activeLicenseVersion;
    }
}
