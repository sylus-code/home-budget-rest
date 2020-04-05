<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405142551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_723705D14C3A3BB ON transaction (payment_id)');
        $this->addSql('ALTER TABLE payment ADD reciever_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5D5C928D FOREIGN KEY (reciever_id) REFERENCES receiver (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D5D5C928D ON payment (reciever_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5D5C928D');
        $this->addSql('DROP INDEX IDX_6D28840D5D5C928D ON payment');
        $this->addSql('ALTER TABLE payment DROP reciever_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14C3A3BB');
        $this->addSql('DROP INDEX IDX_723705D14C3A3BB ON transaction');
        $this->addSql('ALTER TABLE transaction DROP payment_id');
    }
}
