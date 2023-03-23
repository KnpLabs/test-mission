<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230323145535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add article, comment service, comment models.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', commentService_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_23A0E666E3EA7D (commentService_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', commentService_id INT NOT NULL, INDEX IDX_9474526C6E3EA7D (commentService_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_service (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_12EEF8C27294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666E3EA7D FOREIGN KEY (commentService_id) REFERENCES comment_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6E3EA7D FOREIGN KEY (commentService_id) REFERENCES comment_service (id)');
        $this->addSql('ALTER TABLE comment_service ADD CONSTRAINT FK_12EEF8C27294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666E3EA7D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6E3EA7D');
        $this->addSql('ALTER TABLE comment_service DROP FOREIGN KEY FK_12EEF8C27294869C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comment_service');
    }
}
