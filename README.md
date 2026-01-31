# Start - Treinamento Ministerial (ERP)

## Requisitos
- PHP 8+ (PDO MySQL habilitado)
- MySQL 5.7+ / 8+
- Servidor web apontando para a pasta `public`

## Configuracao rapida
1. Copie `.env.example` para `.env` e ajuste as credenciais.
2. Importe o schema: `database/schema.sql`.
3. Rode o seed: `php scripts/seed.php`.
4. (Opcional) Verifique a matriz de acesso: `php scripts/access_check.php`.

## Acesso inicial
- Email e senha do admin vem do `.env` (ADMIN_EMAIL / ADMIN_PASSWORD).
- Troque a senha no primeiro acesso.

## Fluxo de inscricao
- `GET /inscricao` (publico) cria apenas a inscricao pendente.
- `Aprovar` cria Pessoa + Usuario (Aluno) + Matricula em transacao.

## Observacoes
- Inscricao nao cria Pessoa/Usuario/Matricula.
- Hard rules implementadas: nao desativar a si mesmo, secretario nao desativa admin, ownership basico para Pessoas.
