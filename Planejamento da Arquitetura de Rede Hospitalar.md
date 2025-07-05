# Planejamento da Arquitetura de Rede Hospitalar

Este documento detalha o planejamento da arquitetura de rede para um hospital de grande porte com aproximadamente 500 leitos. O projeto será implementado no Cisco Packet Tracer.

## 1. Topologia da Rede

A topologia de rede adotada será a **Hierárquica**, dividida em três camadas:

*   **Camada de Núcleo (Core):** Responsável pelo switching de alta velocidade e pela interconexão das camadas de distribuição. Será composta por 2 switches Layer 3 redundantes para garantir alta disponibilidade.
*   **Camada de Distribuição:** Agrega o tráfego da camada de acesso e aplica políticas de rede, como listas de controle de acesso (ACLs) e roteamento entre VLANs. Será composta por switches Layer 3, conectando os andares e setores do hospital ao núcleo.
*   **Camada de Acesso:** Fornece a conectividade direta aos dispositivos finais (computadores, impressoras, telefones IP, equipamentos médicos, etc.) e aos Access Points. Será composta por switches Layer 2 com suporte a PoE (Power over Ethernet).

## 2. Esquema de Endereçamento IP

Será utilizada a faixa de endereço IP privado **Classe A: 10.0.0.0/8**. O endereçamento será feito utilizando a técnica de **VLSM (Variable Length Subnet Mask)** para otimizar o uso dos endereços IP e criar sub-redes de tamanhos variados para cada setor do hospital.

## 3. Tabela de Sub-redes e VLANs por Setor

A seguir, a tabela com a definição das VLANs e sub-redes para cada setor do hospital:

| ID VLAN | Nome da VLAN (Setor)        | Endereço de Rede   | Máscara de Sub-rede | Endereço de Broadcast | Faixa de Hosts Úteis        | Nº de Hosts |
|---------|-----------------------------|--------------------|---------------------|-----------------------|-----------------------------|-------------|
| 10      | Administração               | 10.10.0.0          | 255.255.252.0 (/22) | 10.10.3.255           | 10.10.0.1 - 10.10.3.254     | 1022        |
| 20      | Clínico/Médico (Enfermarias) | 10.20.0.0          | 255.255.248.0 (/21) | 10.20.7.255           | 10.20.0.1 - 10.20.7.254     | 2046        |
| 30      | UTIs                        | 10.30.0.0          | 255.255.254.0 (/23) | 10.30.1.255           | 10.30.0.1 - 10.30.1.254     | 510         |
| 40      | Bloco Cirúrgico             | 10.40.0.0          | 255.255.254.0 (/23) | 10.40.1.255           | 10.40.0.1 - 10.40.1.254     | 510         |
| 50      | Emergência/Pronto Atendimento | 10.50.0.0          | 255.255.252.0 (/22) | 10.50.3.255           | 10.50.0.1 - 10.50.3.254     | 1022        |
| 60      | Laboratórios                | 10.60.0.0          | 255.255.254.0 (/23) | 10.60.1.255           | 10.60.0.1 - 10.60.1.254     | 510         |
| 70      | Radiologia (PACS)           | 10.70.0.0          | 255.255.252.0 (/22) | 10.70.3.255           | 10.70.0.1 - 10.70.3.254     | 1022        |
| 80      | Farmácia                    | 10.80.0.0          | 255.255.255.0 (/24) | 10.80.0.255           | 10.80.0.1 - 10.80.0.254     | 254         |
| 90      | Equipamentos Médicos (IoT)  | 10.90.0.0          | 255.255.248.0 (/21) | 10.90.7.255           | 10.90.0.1 - 10.90.7.254     | 2046        |
| 100     | Rede de Visitantes (Wi-Fi)  | 10.100.0.0         | 255.255.240.0 (/20) | 10.100.15.255         | 10.100.0.1 - 10.100.15.254  | 4094        |
| 110     | Voz (VoIP)                  | 10.110.0.0         | 255.255.252.0 (/22) | 10.110.3.255          | 10.110.0.1 - 10.110.3.254   | 1022        |
| 120     | Segurança (CFTV)            | 10.120.0.0         | 255.255.252.0 (/22) | 10.120.3.255          | 10.120.0.1 - 10.120.3.254   | 1022        |
| 200     | Datacenter/Servidores       | 10.200.0.0         | 255.255.255.0 (/24) | 10.200.0.255          | 10.200.0.1 - 10.200.0.254   | 254         |

## 4. Configuração dos Servidores

Os servidores estarão localizados na VLAN 200 (Datacenter). A seguir, a lista de servidores e suas configurações:

| Servidor                               | IP             | Máscara         | Gateway        | Serviços                                     |
|----------------------------------------|----------------|-----------------|----------------|----------------------------------------------|
| Servidor de Domínio (AD) / DNS / DHCP  | 10.200.0.10    | 255.255.255.0   | 10.200.0.1     | Active Directory, DNS, DHCP                  |
| Servidor de Prontuários Eletrônicos (PEP) | 10.200.0.11    | 255.255.255.0   | 10.200.0.1     | Aplicação PEP, Banco de Dados                |
| Servidor PACS                          | 10.200.0.12    | 255.255.255.0   | 10.200.0.1     | Armazenamento e comunicação de imagens médicas |
| Servidor de Aplicações (HIS)           | 10.200.0.13    | 255.255.255.0   | 10.200.0.1     | Sistema de Gestão Hospitalar (HIS)           |
| Servidor de Banco de Dados             | 10.200.0.14    | 255.255.255.0   | 10.200.0.1     | Banco de dados para HIS e outras aplicações  |
| Servidor de Backup                     | 10.200.0.15    | 255.255.255.0   | 10.200.0.1     | Software de Backup                           |
| Servidor de Virtualização              | 10.200.0.16    | 255.255.255.0   | 10.200.0.1     | Hypervisor (VMware ESXi / Hyper-V)           |
| Servidor de Segurança (Firewall/Proxy) | 10.200.0.17    | 255.255.255.0   | 10.200.0.1     | Firewall, Proxy, IDS/IPS                     |
| Servidor de E-mail                     | 10.200.0.18    | 255.255.255.0   | 10.200.0.1     | Servidor de E-mail (Exchange / Postfix)      |
| Servidor Web                           | 10.200.0.19    | 255.255.255.0   | 10.200.0.1     | Site do hospital, Portal do Paciente         |
| Servidor de Monitoramento              | 10.200.0.20    | 255.255.255.0   | 10.200.0.1     | Zabbix / Nagios                              |

## 5. Plano de Segurança

*   **Firewall:** Um firewall de borda será configurado para proteger a rede contra ameaças externas. ACLs serão aplicadas nos roteadores e switches de distribuição para controlar o tráfego entre as VLANs.
*   **VLANs:** A segmentação em VLANs, conforme a tabela acima, irá isolar o tráfego dos diferentes setores, aumentando a segurança e o desempenho.
*   **Segurança Wireless:** A rede Wi-Fi de visitantes será completamente isolada da rede interna. A rede Wi-Fi corporativa utilizará autenticação WPA2/WPA3-Enterprise com um servidor RADIUS (integrado ao Active Directory) para autenticação dos usuários.
*   **ACLs (Listas de Controle de Acesso):** Serão implementadas para restringir o acesso a recursos críticos. Por exemplo, a VLAN de Equipamentos Médicos só poderá se comunicar com os servidores específicos de suas aplicações, e a VLAN de Visitantes não terá acesso a nenhuma rede interna.
*   **Segurança Física:** Os equipamentos de rede e servidores serão mantidos em salas seguras com acesso restrito (Datacenter e armários de telecomunicações).

